<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    use HasFactory;

    protected $guarded = ['id','created_at','updated_at'];

    //Relaion uno a muhos inversa
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function venta(){
        return $this->belongsTo(Venta::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
