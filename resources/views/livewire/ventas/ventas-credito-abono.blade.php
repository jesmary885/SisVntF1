<div>
    <button type="submit" class="btn btn-success btn-sm" wire:click="open">
        <i class="fas fa-plus-square"></i>
   </button> 

   @if($isopen)
        <div class="modal d-block" tabindex="-1" role="dialog" style="overflow-y: auto; display: block;" wire:click.self="$set('isopen', false)">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title py-0 text-lg text-gray-800"> <i class="fas fa-money-bill-wave"></i>  Abono de venta a crédito</h5>
                    </div>
                    <div class="modal-body">
                        <h2 class="text-sm ml-2 m-0 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Ingrese el monto recibido por el cliente y presiona Guardar</h2> 
                        <div class="w-1/3 mt-4 ml-4">
                         
                                <input wire:model="total_pagado_cliente" type="number" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Total pagado">
                                <x-input-error for="total_pagado_cliente" />
                         
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