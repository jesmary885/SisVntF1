<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;

    protected $guarded = ['id','created_at','updated_at'];
    
    //Relacion uno a muchos
    public function productos(){
        return $this->hasMany(Producto::class);
    }


    //Relaion uno a muhos inversa
    public function marca(){
        return $this->belongsTo(Marca::class);
    }

      //Relacion uno a muchos
   
     
}
