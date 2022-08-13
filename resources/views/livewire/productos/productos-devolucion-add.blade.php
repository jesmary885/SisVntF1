<div x-data="{ factura: @entangle('factura')}">
    <button type="submit" class="btn btn-primary btn-sm" wire:click="open">
        <i class="fas fa-exchange-alt"></i> Registrar devolución
   </button> 

   @if($isopen)
        <div class="modal d-block" tabindex="-1" role="dialog" style="overflow-y: auto; display: block;" wire:click.self="$set('isopen', false)">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title py-0 text-lg text-gray-800"><i class="fas fa-exchange-alt"></i>  Registro de devolución</h5>
                    </div>
                    <div class="modal-body">
                        <h2 class="text-sm ml-2 mb-4 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Ingrese todos los datos y presiona Guardar</h2> 
                        <div :class="{'hidden': factura != 1}">
                            <input wire:model="nro_factura" type="number" min="1" class="px-2 appearance-none block w-1/2 bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Nro. de factura">
                            <x-input-error for="nro_factura" />
                        </div>
                        <div :class="{'hidden': factura != 0}">
                            <div class="flex justify-between w-full mt-2">
                                <div class="w-full">
                                    <select wire:model="producto_id" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <option value="" selected>Seleccione el producto</option>
                                        @foreach ($productos as $producto)
                                            <option value="{{$producto->producto->id}}">{{$producto->producto->nombre}} {{$producto->producto->modelo->nombre}}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="producto_id" />
                                </div>
                                <div class="w-full ml-2">
                                    <input wire:model.defer="cantidad" type="number" min="0" class="px-2 appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Cantidad">
                                    <x-input-error for="cantidad" />
                                </div>
                                <div class="w-full ml-2">
                                    <select id="accion" wire:model="accion" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="accion">
                                        <option value="" selected>Acción</option>
                                        <option value="1">Reintegro del dinero</option>
                                        <option value="2">Entrega de otro producto igual</option>
                                        <option value="3">Entrega de otro producto distinto</option>
                                    </select>
                                    <x-input-error for="accion" />
                                </div>
                            </div>
                            <div>
                                <textarea wire:model="observaciones" class="mt-2 resize-none rounded-md outline-none w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="observaciones" cols="80" rows="2" required placeholder="Observaciones"></textarea>
                                <x-input-error for="observaciones" />  
                            </div>
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close" >Cerrar</button>
                        <div :class="{'hidden': factura != 1}">
                            <button type="button" class="btn btn-primary disabled:opacity-25" wire:loading.attr="disabled" wire:click="buscar('{{$nro_factura}}')">Buscar</button>
                        </div>
                        <div :class="{'hidden': factura != 0}">
                            <button type="button" class="btn btn-primary disabled:opacity-25" wire:loading.attr="disabled" wire:click="save">Guardar</button>
                        </div>
                    </div>
                </div>
              
            </div>
            
        </div>
   @endif
</div>

