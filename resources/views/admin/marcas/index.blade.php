@extends('adminlte::page')

@section('title', 'TechPeru')

@section('content_header')
    
<div class="flex justify-between">
    
    <h1 class="text-lg ml-2"><i class="fas fa-th-list"></i> Listado de marcas</h1>

    <div class="justify-end">
        @livewire('admin.marcas.marca-import')
    </div>
</div>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    
    @livewire('admin.marcas.marca-index')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop