<div>
    <button type="submit" class="btn btn-secondary btn-sm" wire:click="open" title="Código de barras">
        <i class="fas fa-barcode"></i>
   </button> 

   @if($isopen)
        <div class="modal d-block" tabindex="-1" role="dialog" style="overflow-y: auto; display: block;" wire:click.self="$set('isopen', false)">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title py-0 text-lg text-gray-800"> <i class="fas fa-barcode"></i>  Imprimir códigos de barra</h5>
                    </div>
                    <div class="modal-body">
                        <h2 class="text-sm ml-2 m-0 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Indique la cantidad de códigos a imprimir y presione Generar</h2> 
                        <hr>
                        <div class="flex mt-2 justify-between w-full">
                            <div class="w-1/4 mr-2">
                                <input wire:model.defer="cantidad" name="cantidad" type="number" min="0" class="px-2 appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Cantidad">
                                <x-input-error for="cantidad" />
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close" >Cerrar</button>
                        <button type="button" class="btn btn-primary disabled:opacity-25" wire:loading.attr="disabled" wire:click="print">Generar</button>
                    </div>
                </div>
              
            </div>
            
        </div>
   @endif
</div>



