@extends('adminlte::page')

@section('content_header')

    <div class="flex justify-between">
        <h1 class="flex-1 text-lg"> <i class="fas fa-clipboard-list"></i> Inventario de equipos</h1>
        <div class=" justify-end mr-2">
            @livewire('productos.productos-export',['vista' => 'barra'])
        </div>

         <div class=" justify-end ">
            @livewire('productos.productos-import',['vista' => 'barra'])
        </div> 

        <div class="ml-2 justify-end">
            <a href="{{route('productos.productos.create')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus-square"></i> Nuevo equipo</a>
        </div>
    </div>

    
    
    
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    
    @livewire('productos.productos-index')
@stop

@section('css')



@stop

@section('js')




@stop