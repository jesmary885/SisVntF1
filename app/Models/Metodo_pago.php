<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metodo_pago extends Model
{
    use HasFactory;

    protected $guarded = ['id','created_at','updated_at'];

    public function pagoVentas(){
        return $this->hasMany(Pago_venta::class);
    }

    public function ventas(){
        return $this->hasMany(Venta::class);
    }

    public function compras(){
        return $this->hasMany(Compra::class);
    }
}
