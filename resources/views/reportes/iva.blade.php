@extends('adminlte::page')

@section('content_header')
    
@stop

@section('content')
 @livewire('reportes.iva',['sucursal_id' => $sucursal_id, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin]) 
@stop

@section('css')

@stop

@section('js')

@stop