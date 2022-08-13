<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto_sucursal extends Model
{
    use HasFactory;

    protected $table = "producto_sucursal";
    
    protected $guarded = ['id','created_at','updated_at'];

    //Relacion uno a mucos inversa

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
}
