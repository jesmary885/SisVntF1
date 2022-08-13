@extends('adminlte::page')

@section('content_header')
<div class="flex  justify-between ">
    <h1 class="text-lg ml-2"> <i class="fas fa-clipboard-list"></i> Listado de devoluciones</h1>
    @livewire('productos.productos-devolucion-add')
</div>
@stop

@section('content')
    @livewire('productos.productos-devolucion')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    
@stop