@extends('adminlte::page')

@section('content_header')
<h1 class="flex-1 text-lg"> <i class="fas fa-clipboard-list"></i> Inventario de equipos por lote</h1>
@stop

@section('content')
    @livewire('productos.productos-lote')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop