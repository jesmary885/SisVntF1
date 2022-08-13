<div>
    <div>
        <div class="card mt-2">
            <div class="flex ml-4">
                <i class="fas fa-calendar-alt mt-3 mr-2 text-gray-800"></i>
                <h2 class="text-lg inline mt-2 text-gray-800">Periodo de fechas en que desee realizar la busqueda:</h2>
            </div>
            <div class="flex justify-items-stretch w-full mt-3 mb-2 ml-4">
                <div>
                    <x-input.date wire:model.lazy="fecha_inicio" id="fecha_inicio" placeholder="Seleccione la fecha inicio" class="px-4 outline-none"/>
                    <x-input-error for="fecha_inicio"/>     
                </div>
                <p class="ml-2 mr-2 text-gray-700 font-semibold">-</p>
                <div>
                    <x-input.date wire:model.lazy="fecha_fin" id="fecha_fin" placeholder="Seleccione la fecha fin" class="px-4 outline-none"/>
                    <x-input-error for="fecha_fin"/>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header flex items-center justify-between">

                <div class="flex-1">
                    <input wire:model="search" placeholder="Ingrese el serial o código de barra del producto a buscarIngrese el serial o código de barra del producto a buscar" class="form-control">
                </div>
                
                <div class="ml-2">
                    <button
                        title="Ayuda a usuario"
                        class="btn btn-success btn-sm" 
                        wire:click="ayuda"><i class="fas fa-info"></i>
                        Guía rápida
                    </button>
                </div>
            </div>
 
            @if ($productos->count())
                <div class="card-body">
                    <table class="table table-bordered table-responsive-md table-responsive-sm">
                         <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Código de Barra</th>
                                <th class="text-center">Serial</th>
                                <th class="text-center">Descripción</th>
                                <th class="text-center">Estado</th>
                                <th colspan="1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $producto)
                                <tr>
                                    <td class="text-center">{{$producto->cod_barra}}</td>
                                    <td class="text-center">{{$producto->serial}}</td>
                                    <td class="text-center">{{$producto->producto->nombre}}</td>
                                    <td class="text-center">{{$producto->estado}}</td>
                                    <td width="10px">
                                        <button
                                        class="btn btn-primary btn-sm" 
                                        wire:click="select_product('{{$producto->id}}}')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                      
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer flex justify-start">
                    {{$productos->links()}}

                    <div class="ml-4">
                        <a href="{{route('movimientos.modalidad')}}" class="btn btn-primary"><i class="fas fa-undo-alt"></i> Regresar</a>
                    </div>

                </div>
            @else
                 <div class="card-body">
                    <strong>No hay registros</strong>
                </div>
                
            @endif
                
        </div>
    </div>
</div>
