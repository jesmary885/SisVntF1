<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $guarded = ['id','created_at','updated_at'];

    //Relaion uno a muhos inversa
    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

    public function modelo(){
        return $this->belongsTo(Modelo::class);
    }

    public function marca(){
        return $this->belongsTo(Marca::class);
    }

    //Relacion uno a muchos

    public function producto_sucursals(){
        return $this->hasMany(Producto_sucursal::class);
    }

    public function producto_proformas(){
        return $this->hasMany(Producto_proforma::class);
    }
   
    public function compras(){
        return $this->hasMany(Compra::class);
    }

    public function movimientos(){
        return $this->hasMany(Movimiento::class);
    }

    public function producto_ventas(){
        return $this->hasMany(Producto_venta::class);
    }

    public function devolucions(){
        return $this->hasMany(Devolucion::class);
    }

    public function productos_traslados(){
        return $this->hasMany(ProductosTraslado::class);
    }

    public function producto_lote(){
        return $this->hasMany(Producto_lote::class);
    }

    //Relacion muchos a muchos
    public function sucursals(){
        return $this->belongsToMany(Sucursal::class)->withPivot('cantidad', 'id', 'producto_id','lote');
    }

    //relacion 1 a 1 polimorfica
   /* public function imagen(){
        return $this->morphOne(Imagen::class,"imageable");
    }*/

    public function imagen(){
        return $this->morphOne(Imagen::class, "imageable");
    }

    
  

}
