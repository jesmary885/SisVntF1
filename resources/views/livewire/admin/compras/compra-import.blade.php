<div>
    <button type="submit" class="btn btn-success btn-sm" title="Exportar a excel" wire:click="open">
    <i class="fas fa-file-import"></i> Importar compras
   </button> 

   @if($isopen)
        <div class="modal d-block" tabindex="-1" role="dialog" style="overflow-y: auto; display: block;" wire:click.self="$set('isopen', false)">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title py-0 text-lg text-gray-800"><i class="far fa-file-excel"></i> Importar compras de productos</h5>
                       
                    </div>
                    <div class="modal-body">
                        <h2 class="text-sm ml-2 mb-1 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Descargue la planilla, y complete todos los campos obligatoriamente, guarde el documento y seleccionelo, finalmente haga click en Importar</h2> 
                        <h2 class="text-sm ml-2 mb-1 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> La fecha se debe colocar en formato (Año-mes-dia), ejemplo: 2022-03-21</h2>
                        <h2 class="text-sm ml-2 mb-1 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> En la columna producto debe colocar el código de barra del producto</h2>
                        <h2 class="text-sm ml-2 mb-1 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> En la columna de proveedor, debe colocar el nombre del proveedor pero que sea exactamente igual al nombre registrado en la bdd, ejemplo vj c.a</h2>
                        <h2 class="text-sm ml-2 mb-1 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> En la columna de usuario debe colocar el Email del usuario que registro la compra, pero que sea exactamente igual al registrado en la bdd, ejemplo admin@tech.com</h2>
                        <h2 class="text-sm ml-2 mb-4 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Mantener el nombre de las columnas como se encuentran.</h2>  
                        <form class="w-full" action="{{route('admin.compras.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="file" name="import_file">
                            <x-input-error for="import_file" />
                            <div class="flex justify-end mt-4">
                                <div>
                                    <button type="submit" class="mr-2 btn btn-success disabled:opacity-25 justify-center" wire:loading.attr="disabled" ><i class="far fa-file-excel"></i> Importar</button>
                                </div>
                                <hr>
                            </div>
                        </form>
                        <hr>
                        <div class="flex justify-end mt-4">
                            <div>
                                <button type="submit" class="mr-2 btn btn-success disabled:opacity-25" wire:loading.attr="disabled" wire:click="planilla()" ><i class="fas fa-download"></i> Descargar planilla</button>
                            </div>
                            <div >
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close" >Cerrar</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                       
                    
                    </div>
                </div>
              
            </div>
            
        </div>
   @endif
</div>