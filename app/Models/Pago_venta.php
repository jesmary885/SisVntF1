<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago_venta extends Model
{
    use HasFactory;

    protected $guarded = ['id','created_at','updated_at'];

    //Relaion uno a muhos inversa

    public function venta(){
        return $this->belongsTo(User::class);
    }

    public function metodoPago(){
        return $this->belongsTo(Metodo_pago::class);
    }

}
