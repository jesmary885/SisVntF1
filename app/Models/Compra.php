<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $guarded = ['id','created_at','updated_at'];

    //Relaion uno a muhos inversa

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }

    public function caja(){
        return $this->belongsTo(Caja::class);
    }

    public function metodoPago(){
        return $this->belongsTo(Metodo_pago::class);
    }

    public function moneda(){
        return $this->belongsTo(Moneda::class);
    }

}
