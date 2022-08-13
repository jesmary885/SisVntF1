@extends('adminlte::page')

@section('content_header')
@stop

@section('content')
    @livewire('productos.productos-historial-prod-serial')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop