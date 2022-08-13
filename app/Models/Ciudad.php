<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'estado_id'];

    //Relacion uno a muchos inversa
    public function estado(){
        return $this->belongsTo(Estado::class);
    }

    public function clientes(){
        return $this->hasMany(Cliente::class);
    }

    public function proveedors(){
        return $this->hasMany(Proveedor::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

}
