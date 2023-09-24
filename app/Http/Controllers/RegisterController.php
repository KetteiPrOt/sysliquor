<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WarehouseStatus;
use App\Models\Register;
use App\Http\Requests\StoreRegisterRequest;

class RegisterController extends Controller
{
    public function show(WarehouseStatus $warehouseStatus, Register $register){
        // Uso esta ruta para cubrir la ruta put del metodo edit()
        return redirect()->route('warehouseStates.show', $warehouseStatus->id);
    }

    public function edit(WarehouseStatus $warehouseStatus, Register $register){
        return view('registers.edit', compact('warehouseStatus', 'register'));
    }

    public function update(StoreRegisterRequest $request, WarehouseStatus $warehouseStatus, Register $register){

        $register->update($request->all());
        
        return redirect()->route('warehouseStates.show', $warehouseStatus->id);
    }
}
