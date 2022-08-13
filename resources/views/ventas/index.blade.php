@extends('adminlte::page')

@section('content_header')
    <h1 class="text-lg ml-2"><i class="fas fa-list-ul"></i> Listado de ventas</h1>
@stop

@section('content')
    @if ($tipo == 'contado')
        @livewire('ventas.ventas-contado',['sucursal'=> $sucursal])
    @else
        @livewire('ventas.ventas-credito',['sucursal'=> $sucursal])

    @endif
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop