<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WarehouseStatus;
use App\Http\Requests\StoreWarehouseStatusRequest;
use App\Models\Register;
use App\Models\Product;
use App\Models\RawRegister;

class WarehouseStatusController extends Controller
{
    public function index(){
        $warehouseStates = WarehouseStatus::orderBy('date', 'desc')->paginate(10);
        return view('warehouse-states.index', compact('warehouseStates'));
    }

    public function create(){
        return view('warehouse-states.create');
    }

    public function store(StoreWarehouseStatusRequest $request){
        // Crear Estado de Bodega
        $warehouseStatus = WarehouseStatus::create([
            'date' => $request->collect()->get('date')
        ]);

        $id = $warehouseStatus->id;

        // Crear registros del Estado de Bodega con los productos que tenemos
        $products = Product::all();
        foreach($products as $product){
            $register = new Register;
            $register->warehouse_status_id = $id;
            $register->product_id = $product->id;
            $register->save();
        }
        
        return redirect()->route('warehouseStates.show', $id);
    }

    public function show(WarehouseStatus $warehouseStatus){
        $id = $warehouseStatus->id;
        $date = $warehouseStatus->date;

        // Consulta si hay un Estado de Bodega previo
        $previuosStatus = WarehouseStatus::where('date', '<', $date)->orderBy('date', 'desc')
                                        ->first();

        /* --- 
            Crea tablas temporales para calcular la informacion que le mostraremos al usuario 
            usando los registros del Estado de Bodega actual y anterior (si es que existe)
         --- */
        Register::createTemporaryTables($warehouseStatus, $previuosStatus);

        /* --- 
            Obtiene un parametro $search y $orderBy para realizar la busqueda por nombre de producto, 
            y obtener el campo segun el cual ordenarlo. 
            Despues obtiene la informacion que le mostraremos al usuario como 'registros rasos' ($rawRegisters)
         --- */
        $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : 'product';
        $order = isset($_GET['order']) ? $_GET['order'] : 'asc';
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        $orderBy = match($orderBy){
            'product' => 'name',
            'total' => 'total_count',
            'previous' => 'previous_count',
            'sales' => 'sales',
            default => 'name'
        };

        $order = match($order){
            'asc' => 'asc',
            'desc' => 'desc',
            default => 'asc'
        };

        if($search){
            $rawRegisters = RawRegister::where('name', 'like', '%' . $search . '%')
                                         ->orderBy($orderBy, $order)->paginate(5);

            $rawRegisters->appends(['search' => $search]);
            /* 
                $rawRegister->attributes = [
                    "id" => 0,
                    "type" => "whisky",
                    "name" => "Producto 1",
                    "content" => 200,
                    "deposit" => 0,
                    "liquor_shop" => 0,
                    "total_count" => 0,
                    "previous_count" => 0 | null,
                    "ordered" => 0,
                    "sales" => 0
                ];
            */
        } else {
            $rawRegisters = RawRegister::orderBy($orderBy, $order)->paginate(5);
            $rawRegisters->appends(['orderBy' => $orderBy, 'order' => $order]);
        }

        return view('registers.index', [
            'search' => $search,
            'orderBy' => $orderBy,
            'order' => $order,
            'date' => $date,
            'id' => $id,
            'rawRegisters' => $rawRegisters
        ]);       
    }

    public function destroy(WarehouseStatus $warehouseStatus){
        $warehouseStatus->delete();
        return redirect()->route('warehouseStates.index');
    }
}
