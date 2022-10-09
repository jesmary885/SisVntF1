<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $guarded = ['id','created_at','updated_at'];

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }

    //Relacion uno a muchos

    public function movimientoCajas(){
        return $this->hasMany(MovimientoCaja::class);
    }

    public function ventas(){
        return $this->hasMany(Venta::class);
    }

    public function compras(){
        return $this->hasMany(Compra::class);
    }

}
