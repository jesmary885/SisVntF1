<div>
    <button type="submit" class="btn btn-primary btn-sm" wire:click="open">
        <i class="fas fa-edit"></i>
   </button> 

   @if($isopen)
        <div class="modal d-block" tabindex="-1" role="dialog" style="overflow-y: auto; display: block;" wire:click.self="$set('isopen', false)">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title py-0 text-lg text-gray-800"> <i class="fas fa-barcode"></i>  Registro de serial de equipo</h5>
                    </div>
                    <div class="modal-body">
                        <h2 class="text-sm ml-2 mb-4 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Ingrese el serial del equipo y presiona Guardar</h2> 
                       
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close" >Cerrar</button>
                    <button type="button" class="btn btn-primary disabled:opacity-25" wire:loading.attr="disabled" wire:click="save">Guardar</button>
                </div>
            </div>
        </div>
   @endif
</div>
