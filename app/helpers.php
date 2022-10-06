<?php

use App\Models\Producto;
use App\Models\Producto_lote;
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



function qty_available($producto_id,$sucursal_id,$producto_lote){

    $pivot = Pivot::where('sucursal_id',$sucursal_id)
                        ->where('producto_id',$producto_id)
                        ->where('lote',$producto_lote->lote)
                        ->first();

    //$producto_lote_select = Producto_lote::where('id',$producto_lote->id)->first();

    $quantity = $pivot->cantidad;

    return $quantity - qty_added($producto_id);
}


function discount($item,$sucursal_id,$cant,$lote){

    // $producto = Producto::find($item->id);

    $producto_lote = Producto_lote::where('id',$lote)->first();

    $qty_available = qty_available($item,$sucursal_id,$producto_lote);

    $pivot = Pivot::where('sucursal_id',$sucursal_id)
        ->where('producto_id',$item)
        ->where('lote',$producto_lote->lote)
        ->first();

    $pivot->cantidad = $pivot->cantidad - $cant;
    $pivot->save();

    $producto_lote->update([
        'stock' => ($producto_lote->stock - $cant)
    ]);
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