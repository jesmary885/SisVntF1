<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $guarded = ['id','created_at','updated_at'];
    
    //Relacion uno a muchos
    public function modelos(){
        return $this->hasMany(Modelo::class);
    }

    public function productos(){
        return $this->hasMany(Producto::class);
    }

 
}
