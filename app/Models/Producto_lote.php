<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto_lote extends Model
{
    use HasFactory;

    protected $table = "producto_lotes";
    
    protected $guarded = ['id','created_at','updated_at'];

    //Relacion uno a mucos inversa

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    


}
