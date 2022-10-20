<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $guarded = ['id','created_at','updated_at'];

    //Relaion uno a muhos inversa

    public function cliente(){
        return $this->belongsTo(Cliente::class);
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

    //Relacion uno a muchos
   
    public function producto_ventas(){
        return $this->hasMany(Producto_venta::class);
    }

    public function devolucions(){
        return $this->hasMany(Devolucion::class);
    }

    public function pagoVentas(){
        return $this->hasMany(Pago_venta::class);
    }

    
}
