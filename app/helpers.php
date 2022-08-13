<?php

use App\Models\Producto;
use App\Models\Sucursal;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Producto_sucursal as Pivot;

 function quantity($producto_id,$sucursal_id){

    $pivot = Pivot::where('sucursal_id',$sucursal_id)
                        ->where('producto_id',$producto_id)
                        ->first();

    $quantity = $pivot->cantidad;
     return $quantity;
 }

function qty_added($producto_id){
    $cart = Cart::content();
    $item = $cart->where('id', $producto_id)->first();

    if($item){
        return $item->qty;
    }else{
        return 0;
    }

}



function qty_available($producto_id,$sucursal_id){

    $pivot = Pivot::where('sucursal_id',$sucursal_id)
                        ->where('producto_id',$producto_id)
                        ->first();

    $quantity = $pivot->cantidad;

    return $quantity - qty_added($producto_id);
}


function discount($item,$sucursal_id,$cant){

    // $producto = Producto::find($item->id);
    $qty_available = qty_available($item,$sucursal_id);

    $pivot = Pivot::where('sucursal_id',$sucursal_id)
                         ->where('producto_id',$item)
                         ->first();
    $pivot->cantidad = $pivot->cantidad - $cant;
    $pivot->save();

}

function increase($item,$sucursal_id){

    // $producto = Producto::find($item->id);
    $quantity = quantity($item->id,$sucursal_id) + $item->qty;

    $pivot = Pivot::where('sucursal_id',$sucursal_id)
                         ->where('producto_id',$item->id)
                         ->first();

    $pivot->cantidad = $quantity;
    $pivot->save();

}