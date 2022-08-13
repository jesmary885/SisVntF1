<div>
    <button type="submit" class="btn btn-primary btn-sm float-right" wire:click="open">
        @if ($accion == 'create')
        <i class="fas fa-warehouse"></i> Nueva sucursal 
        @else
        <i class="fas fa-edit"></i>
        @endif
    </button>

    @if ($isopen)
        <div class="modal d-block" tabindex="-1" role="dialog" style="overflow-y: auto; display: block;"
            wire:click.self="$set('isopen', false)">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title py-0 text-lg text-gray-800"> <i class="fas fa-user-tie"></i>  Registro de sucursales</h5>
                    </div>
                    <div class="modal-body">
                        <h2 class="text-sm ml-2 m-0 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Complete todos los campos y presiona Guardar</h2> 
                        <hr>
                        <div class="flex mt-2 justify-between w-full">
                            <div class="w-full mr-2">
                                <input wire:model="nombre" type="text" title="Nombre"
                                    class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    placeholder="Nombre de la sucursal">
                                <x-input-error for="nombre" />
                            </div>
                            <div class="w-full mr-2">
                                <input wire:model="telefono" type="number" title="Teléfono"
                                    class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    placeholder="Teléfono">
                                <x-input-error for="telefono" />
                            </div>
                        </div>


                        <div class="w-full mt-2 mr-2">

                                <input wire:model="direccion" type="text" title="Dirección"
                                    class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    placeholder="Dirección">
                                <x-input-error for="direccion" />
                      
                        </div>

                        <div class="flex justify-between w-full mt-2">
                            <div class="w-full mr-2">
                                <select wire:model="estado_id" title="Estado/provincia/region"
                                    class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="" selected>Estado/provincia/region</option>
                                    @foreach ($estados as $estado)
                                        <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="estado_id" />
                                
                            </div>

                            <div class="w-full mr-2">
                                <select wire:model="ciudad_id" title="Ciudad"
                                    class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="" selected>Seleccione la ciudad</option>
                                    @foreach ($ciudades as $ciudad)
                                        <option value="{{ $ciudad->id }}">{{ $ciudad->nombre }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="ciudad_id" />
                                
                            </div>
                        </div>
                        <div class="flex w-full h-full mt-3 ml-2">
                            <input type="checkbox" class=" mt-1" wire:model="status" value="1">
                            <p class="text-md font-semibold text-green-800 ml-2">Habilitar</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close">Cerrar</button>
                        <button type="button" class="btn btn-primary" wire:click="save">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

