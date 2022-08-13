<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
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

    //Relacion uno a muchos
   
    public function producto_proformas(){
        return $this->hasMany(Producto_proforma::class);
    }




}
