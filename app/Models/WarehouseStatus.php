<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Register;

class WarehouseStatus extends Model
{
    use HasFactory;

    protected $table = 'warehouse_states',
              $fillable = ['date'];

    public function registers(){
        return $this->hasMany(Register::class);
    }
}
