@extends('adminlte::page')
@section('content_header')
    
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            {{session('info')}}
        </div>
        @endif
        <div class="card">
            <div class="card-body">
                {!! Form::model($role, ['route' => ['admin.roles.update',$role], 'method' => 'put']) !!}
                    @include('admin.roles.partials.form')
                    {!! Form::submit('Guardar', ['class' => 'btn btn-primary mt-4']) !!}
                    <a href="{{route('admin.roles.index')}}" class="btn btn-primary mt-4 ml-2"><i class="fas fa-undo-alt"></i> Regresar</a>
                {!! Form::close() !!}
            </div>
        </div>
    @stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop