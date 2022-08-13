@extends('adminlte::page')

@section('content_header')
@stop

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title py-0 text-lg text-gray-500 ml-2"> <i class="fas fa-chart-pie"></i>  Modalidad del reporte</h5>
            </div>
            <div class="card-body">

                <h2 class="text-sm ml-2 mb-4 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Complete el campo solicitado y presiona Buscar</h2>
                <form method="POST" action="{{ route('movimientos.buscar') }}">
                    @csrf
                    <div class="flex items-center">
                        <div>
                            <select id="modalidad" class="w-52 form-control h-8 text-m" name="modalidad">
                                <option value="" selected>Seleccione una opción</option>
                                <option value="1">Productos por código de barra</option>
                                <option value="2">Productos por serial</option>
                            </select>

                            <x-input-error for="modalidad" />
                        </div>
                        <div class="ml-2 flex-1 items-center">
                            <x-button>
                                {{ __('Buscar') }}
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop