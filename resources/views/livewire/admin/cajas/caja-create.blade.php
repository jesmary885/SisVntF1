<div>
    <button type="submit" class="btn btn-primary btn-sm float-right" wire:click="open">
        @if ($accion == 'create')
        <i class="fas fa-plus-square"></i> Nueva caja
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
                        <h5 class="modal-title py-0 text-lg text-gray-800"> <i class="fas fa-check-double"></i>  Registro de cajas</h5>
                    </div>
                    <div class="modal-body">
                        <h2 class="text-sm ml-2 m-0 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Complete todos los campos y presiona Guardar</h2> 
                        <hr>
                        <div class="flex justify-between w-full mt-2">
                            <div class="w-full mr-2">
                                <input wire:model="nombre" type="text"
                                    class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    placeholder="Nombre de la caja">
                                <x-input-error for="nombre" />
                            </div>
                            <div class="w-full">
                                <select wire:model="sucursal_id" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="" selected>Seleccione la sucursal</option>
                                    @foreach ($sucursales as $sucursal)
                                        <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="sucursal_id" />
                            </div>
                        </div>
                        <div class="flex justify-between w-full mt-2">
                            <div class="w-full mr-2">
                                <input wire:model="saldo_bolivares" type="number" title="Saldo"
                                    class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    placeholder="Saldo en Bolivares">
                                <x-input-error for="saldo_bolivares" />
                            </div>
                            <div class="w-full mr-2">
                                <input wire:model="saldo_dolares" type="number" title="Saldo"
                                    class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    placeholder="Saldo en Dólares">
                                <x-input-error for="saldo_dolares" />
                            </div>
                            
                        </div>

                        <div class="w-full mt-2">
                                <select wire:model="status" title="Estado" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="" selected>Estado de la caja</option>
                                    <option value="Habilitada">Habilitada</option>
                                    <option value="Deshabilitada">Deshabilitada</option>
                         
                                </select>
                                <x-input-error for="status" />
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