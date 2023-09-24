<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Type;
use App\Models\Presentation;
use App\Models\Register;
use Ramsey\Uuid\Type\Integer;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['type_id', 'presentation_id', 'name'];

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function presentation(){
        return $this->belongsTo(Presentation::class);
    }

    public function registers(){
        return $this->hasMany(Register::class);
    }

    public static function findProducts($search){
        // Obtiene los productos
        $products = Product::where('name', 'like', '%' . $search . '%')
                           ->orderBy('name', 'asc')->paginate(10);

        $products->appends(['search' => $search]);

        // Retorna los productos
        return $products;

    }

    public static function saveProduct($data){
        $type_id = Type::where('name', $data->get('type'))->value('id');
        $presentation_id = Presentation::where('content', $data->get('presentation'))->value('id');
        Product::create([
            'name' => $data->get('name'),
            'type_id' => $type_id,
            'presentation_id' => $presentation_id
        ]);
    }

    public static function findRelations($product){
        // Obtiene el tipo y la presentacion relacionadas a al producto
        $product->type;
        $product->presentation;

        // Retorna el producto
        return $product;
    }

    public static function updateProduct($data, $product){
        $product->name = $data->get('name');

        $newType = Type::where('name', $data->get('type'))->first();
        $product->type_id = $newType->id;

        $newPresentation = Presentation::where('content', $data->get('presentation'))->first();
        $product->presentation_id = $newPresentation->id;

        $product->save();
    }
}
