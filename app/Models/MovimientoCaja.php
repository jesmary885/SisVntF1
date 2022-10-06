<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientoCaja extends Model
{
 

    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    /*tIPO DE MOVIMIENTOS
    1: Ingreso
    2: Egreso
    3: Transferencia
    4. Apertura
    5. Cierre*/

    //Relaion uno a muhos inversa

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }

    public function caja(){
        return $this->belongsTo(Caja::class);
    }
}
