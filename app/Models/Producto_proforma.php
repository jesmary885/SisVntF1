<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto_proforma extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    //Relaion uno a muhos inversa
    public function proforma(){
        return $this->belongsTo(Proforma::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

}
