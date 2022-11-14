<div>
    <button type="submit" class="btn btn-success btn-sm" wire:click="open" title="Abono de deuda">
        <i class="fas fa-plus-square"></i>
   </button> 

   @if($isopen)
        <div class="modal d-block" tabindex="-1" role="dialog" style="overflow-y: auto; display: block;" wire:click.self="$set('isopen', false)">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title py-0 text-lg text-gray-800"> <i class="fas fa-money-bill-wave"></i>  Abono de venta a crédito</h5>
                    </div>
                    <div class="modal-body">
                        <h2 class="text-sm ml-2 m-0 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Ingrese los datos y presiona Guardar</h2> 
                        <div class="flex justify-between w-full h-full mt-6">
                            <div class="w-full mr-2 ml-2">
                                <select wire:model.lazy="metodo_id" class="block w-full bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="" selected>Seleccione el método pago</option>
                                    @foreach ($metodos as $metodo)
                                        <option value="{{$metodo->id}}">{{$metodo->nombre}}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="metodo_id" />
                            </div>

                            <div class="w-full mr-2">
                                <select wire:model.lazy="caja_id" class="block w-full bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="" selected>Seleccione la caja</option>
                                    @foreach ($cajas as $caja)
                                        <option value="{{$caja->id}}">{{$caja->nombre}}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="caja_id" />
                            </div>

                            <div class="w-full">
                                <input wire:model="total_pagado_cliente" type="number" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Monto pagado">
                                <x-input-error for="total_pagado_cliente" />
                            </div>
                         
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close" >Cerrar</button>
                        <button type="button" class="btn btn-primary" wire:click="update">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
   @endif
</div>
