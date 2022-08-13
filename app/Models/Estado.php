<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    
    //Relacion uno a muchos
    public function ciudades(){
        return $this->hasMany(Ciudad::class);
    }

    //Relacion uno a muchos
   
    public function users(){
        return $this->hasMany(User::class);
    }

    public function clientes(){
        return $this->hasMany(Cliente::class);
    }

    public function proveedors(){
        return $this->hasMany(Proveedor::class);
    }
}
