@extends('adminlte::page')

@section('content_header')
    
@stop

@section('content')

 @livewire('ventas.ventas-cart',['sucursal' => $sucursal])
@stop

@section('css')

@stop

@section('js')

@stop