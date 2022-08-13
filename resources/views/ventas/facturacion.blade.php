@extends('adminlte::page')

@section('content_header')
    
@stop

@section('content')

 @livewire('ventas.venta-facturacion',['sucursal' => $sucursal,'proforma' => $proforma])
@stop

@section('css')

@stop

@section('js')

@stop