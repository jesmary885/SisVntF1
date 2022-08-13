@extends('adminlte::page')


@section('content_header')


<div class="flex justify-between">
    <h1 class="flex-1 text-lg ml-2"> <i class="fas fa-clipboard-list"></i> Listado de equipos por serial</h1>
    <div class="mr-2 justify-end ">
        @livewire('productos.productos-export',['vista' => 'serial'])
    </div>

    <div class=" justify-end ">
        @livewire('productos.productos-import',['vista' => 'serial'])
    </div>
</div>




@stop



@section('content')
    @livewire('productos.productos-serial-index',['sucursal' => $sucursal])
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop