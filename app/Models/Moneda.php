<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    use HasFactory;

    protected $guarded = ['id','created_at','updated_at'];

    public function tasa(){
        return $this->hasMany(tasa_dia::class);
    }
}
