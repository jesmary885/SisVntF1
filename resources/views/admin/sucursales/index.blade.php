@extends('adminlte::page')

@section('title', 'TechPeru')

@section('content_header')
   
    <h1 class="text-lg ml-2"><i class="fas fa-warehouse"></i> Listado de sucursales</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    
    @livewire('admin.sucursales.sucursal-index')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop