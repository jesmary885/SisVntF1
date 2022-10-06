<div>
    <button type="submit" class="font-medium text-blue-500 hover:underline" wire:click="open">
        Cerrar
    </button>

    @if ($isopen)
        <div class="modal d-block" tabindex="-1" role="dialog" style="overflow-y: auto; display: block;"
            wire:click.self="$set('isopen', false)">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title py-0 text-lg text-gray-800"> <i class="fas fa-check-double"></i>  Cierre de caja</h5>
                    </div>
                    <div class="modal-body">
                        <h2 class="text-sm ml-2 m-0 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Complete el campo y presiona Guardar</h2> 
                        <hr>
                        <textarea wire:model="observaciones" class="resize-none rounded-md outline-none w-full px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="observaciones" cols="80" rows="2" required placeholder="Observaciones"></textarea>
                        <x-input-error for="observaciones" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close">Cerrar</button>
                        <button type="button" class="btn btn-primary" wire:click="cerrar">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif


</div>
