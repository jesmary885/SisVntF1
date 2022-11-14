@extends('adminlte::page')

@section('content_header')
    
@stop


@section('content')
    @livewire('ventas.ventas-seleccion-sucursal',['vista' => $vista, 'proforma' => $proforma])
@stop

@section('css')

@stop

@section('js')

@stop