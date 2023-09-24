<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Presentation;
use App\Models\Type;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    public function index(){
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        if($search){
            $products = Product::where('name', 'like', '%' . $search . '%')
                               ->orderBy('name', 'asc')
                               ->paginate(10);
            $products->appends(['search' => $search]);
        } else {
            $products = Product::orderBy('name', 'asc')->paginate(5);
        }

        return view('products.index', compact('products', 'search'));
    }

    public function create(){
        $presentations = Presentation::all();
        $types = Type::all();
        return view('products.create', compact('presentations', 'types'));
    }

    public function store(StoreProductRequest $request){
        $data = $request->collect();
        Product::saveProduct($data);
        return redirect()->route('products.index');
    }

    public function show(){
        // Originalmente deberia mostrar un producto, pero lo usaremos para cubir la ruta PUT
        return redirect()->route('products.index');
    }

    public function edit(Product $product){
        $product = Product::findRelations($product);
        $presentations = Presentation::all();
        $types = Type::all();
        return view('products.edit', compact('presentations', 'types', 'product'));
    }

    public function update(StoreProductRequest $request, Product $product){
        $data = $request->collect();

        Product::updateProduct($data, $product);

        return redirect()->route('products.index');
    }

    public function destroy(Product $product){
        $product->delete();
        return redirect()->route('products.index');
    }
}
