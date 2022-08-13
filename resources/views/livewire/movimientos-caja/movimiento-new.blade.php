<div x-data="{ tipo_movimiento: @entangle('tipo_movimiento')}">
    <button type="submit" class="btn btn-primary btn-sm"
      title="Nuevo movimiento"
        wire:click="open">
            <i class="fas fa-hand-holding-usd"></i>
                    Nuevo movimiento
    </button>

    @if ($isopen)
        <div class="modal d-block" tabindex="-1" role="dialog" style="overflow-y: auto; display: block;"
            wire:click.self="$set('isopen', false)">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
           
                        <h5 class="modal-title py-0 text-lg text-gray-800"> <i class="fas fa-hand-holding-usd"></i>  Registro de movimiento de caja</h5>
                    </div>
                    <div class="modal-body">

                        <h2 class="text-sm ml-2 m-0 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Complete todos los campos y presiona Guardar</h2> 
                        <hr>

                        <div class="flex mt-2 justify-between w-full">
                            <div class="w-3/4 mr-2">
                                <select wire:model="tipo_movimiento" id="tipo_movimiento"
                                    class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    name="tipo_documento" title="Tipo de documento">
                                    <option value="" selected>*Tipo de movimiento</option>
                                    <option value="1">Ingreso</option>
                                    <option value="2">Egreso</option>
                                    <option value="3">Transferencia</option>
                                </select>
                                <x-input-error for="tipo_movimiento" />
                            </div>

                            <div class="w-full mr-2">
                                <input wire:model.defer="cantidad" type="number"
                                    class="px-2 appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    placeholder="*Cantidad" min="0" title="Monto">
                                <x-input-error for="cantidad" />
                            </div>
                        </div>

                        <div class="flex justify-between w-full mt-2 mr-2">
                            <div class="w-full mr-2">
                                    <textarea wire:model="observaciones" class="mt-2 resize-none rounded-md outline-none w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="observaciones" cols="80" rows="2" required placeholder="Observaciones"></textarea>
                                    <x-input-error for="observaciones" />
                            </div>
                            
                        </div>

                        <div class="w-full mr-2 mt-2" :class="{'hidden': tipo_movimiento != 3}">
                            <select wire:model="sucursal_id" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="" selected>Sucursal destino</option>
                                    @foreach ($sucursales as $sucursale)
                                        <option value="{{$sucursale->id}}">{{$sucursale->nombre}}</option>
                                    @endforeach
                            </select>    
                            <x-input-error for="sucursal_id" />
                           
                        </div>

                       

             
                       
                    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close">Cerrar</button>
                        <button  wire:loading.attr="disabled" type="button" class="btn btn-primary" wire:click="save">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

