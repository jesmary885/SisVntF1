<div>
    <div>
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <div class="flex-1">
                    <div class=flex>
                        <div class="w-1/4">
                   
                            <select wire:model="buscador" id="buscador" class="form-control text-m" name="buscador">
                                <option value="0">Código de barra</option>
                                <option value="1">Serial</option>
                            </select>
        
                            <x-input-error for="buscador" />
    
                        </div>
                        <input wire:model="search" placeholder="Ingrese {{$item_buscar}}" class="form-control ml-2">

                    </div>
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
                    <div class="m-0 p-0">
                        <h2 class="text-sm ml-2 m-0 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Complete el campo de observaciones y haga click en <i class="fas fa-check-circle"></i> encontrado al lado del producto a regresar a inventario</h2>
                     </div>

                     <div class="mt-4 mb-2">
                        <textarea wire:model="observaciones" class="resize-none rounded-md outline-none w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="observaciones" cols="80" rows="2" required placeholder="Observaciones"></textarea>
                <x-input-error for="observaciones" />
                    </div>

                    <hr>

                    <table class="table table-bordered table-responsive-lg table-responsive-md table-responsive-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Código de Barra</th>
                                <th class="text-center">Serial</th>
                                <th class="text-center">Categoria</th>
                                <th class="text-center">Marca</th>
                                <th class="text-center">Modelo</th>
                                <th colspan="1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $producto)
                                <tr>
            
                                    <td class="text-center">{{$producto->productoSerialSucursal->cod_barra}}</td>
                                    <td class="text-center">{{$producto->productoSerialSucursal->serial}}</td>   
                                    <td class="text-center">{{$producto->productoSerialSucursal->categoria->nombre}}</td>    
                                    <td class="text-center">{{$producto->productoSerialSucursal->marca->nombre}}</td>
                                    <td class="text-center">{{$producto->productoSerialSucursal->modelo->nombre}}</td>          
                                    <td width="10px">
                                        <button
                                            class="btn btn-danger btn-sm" 
                                            wire:click="regresar('{{$producto->id}}')"
                                            title="Regresar a inventario">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            @else
                 <div class="card-body">
                    <strong>No hay registros</strong>
                </div>
            @endif
                
        </div>
    </div>
</div>