@extends('adminlte::page')

@section('content_header')
    
@stop

@section('content')
 @livewire('ventas.ventas-seleccion-productos',['sucursal' => $sucursal, 'proforma' => $proforma, 'caja' => $caja]) 


@stop

@section('css')

@stop

@section('js')

@stop