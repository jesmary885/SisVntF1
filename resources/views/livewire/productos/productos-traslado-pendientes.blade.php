<div >
    <h5 class="modal-title ml-4 mt-2 text-md text-gray-800"> <i class="fas fa-boxes"></i> Equipos agregados para traslado
    </h5>
    
    <div class="card-body">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <div class=flex>
                    <div class="w-1/4">

                        <select wire:model="buscador" id="buscador" class="form-control text-m" name="buscador">
                            <option value="0">Presentación</option>
                            <option value="1">Marca</option>
                            <option value="2">Categoria</option>
                            <option value="3">Código de barra</option>
                      
                        </select>

                        <x-input-error for="buscador" />

                    </div>
                    <input wire:model="search" placeholder="Ingrese {{ $item_buscar }}"
                        class="form-control mb-2">

                </div>
            </div>
            <div class="ml-2">
                <button title="Ayuda a usuario" class="btn btn-success btn-sm" wire:click="ayuda"><i
                        class="fas fa-info"></i>
                    Guía rápida
                </button>
            </div>

        </div>

        @if ($productos_pendientes->count())

            <table class="table table-bordered table-responsive-lg table-responsive-md table-responsive-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>Cantidad</th>
                        <th>Lote</th>
                        <th>Prod/Cat</th>
                        <th>Marc/Pres</th>
                        <th>Sucursal destino</th>

                     
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos_pendientes as $producto)
                        <tr>
                            <td>{{$producto->cantidad}}</td>
                            <td>{{$producto->lote}}</td>
                            <td>{{ $producto->producto->nombre }}/{{ $producto->producto->categoria->nombre }}
                            </td>
                            <td>{{ $producto->producto->marca->nombre }}/{{ $producto->producto->modelo->nombre }}
                            </td>
                            <td>{{ $producto->sucursal->nombre }}
                            </td>
                            <td width="10px">
                                <button
                                class="btn btn-danger btn-sm" 
                                wire:click="less('{{$producto->id}}')"
                                title="Eliminar unidad">
                                <i class="fas fa-window-minimize"></i>
                                </button>
                            </td>
                            <td width="10px">
                                <button
                                class="btn btn-danger btn-sm" 
                                wire:click="delete('{{$producto->id}}')"
                                title="Anular traslado">
                                <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
    <div class="card-footer flex">

            {{ $productos_pendientes->links() }}

            <x-button class="ml-2"
            wire:click="Export_pdf" title="Descargar planilla de traslado" >
            <i class="fas fa-download mr-2"></i> Descargar planilla
            </x-button>
    </div>

    
@else
    <div class="card-body">
        <strong>No hay registros</strong> <br>
    </div>
    @endif
</div>