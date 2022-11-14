<div>
    <button type="submit" class="btn btn-success btn-sm" title="Exportar a excel" wire:click="open">
    <i class="fas fa-file-import"></i> Importar inventario
    </button> 

   @if($isopen)
        <div class="modal d-block" tabindex="-1" role="dialog" style="overflow-y: auto; display: block;" wire:click.self="$set('isopen', false)">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title py-0 text-lg text-gray-800"><i class="far fa-file-excel"></i> Importar productos</h5>
                    </div>
                    <div class="modal-body">

                      

                        @if ($vista == 'barra')
                        <h2 class="text-sm ml-2 mb-1 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Descargue la planilla, y complete todos los campos obligatoriamente, guarde el documento y seleccionelo, finalmente haga click en Importar.</h2> 
                        <h2 class="text-sm ml-2 mb-1 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> En las columnas con el nombre de cada sucursal va a colocar el stock del producto en dicha sucursal.</h2>
                        <h2 class="text-sm ml-2 mb-1 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Mantener el nombre de las columnas como se encuentran.</h2>  
                        <hr>
                        @else
                        <h2 class="text-sm ml-2 mb-1 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Descargue la planilla, y complete todos los campos obligatoriamente, guarde el documento y seleccionelo, finalmente haga click en Importar</h2> 
                        <h2 class="text-sm ml-2 mb-1 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> En la columna sucursal va a colocar el nombre de la sucursal donde se encuentra el producto, con los nombres de las sucursales tal como se encuentran en la planilla (Casa matriz,Tienda Lima 1,Movox).</h2>
                        <h2 class="text-sm ml-2 mb-1 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> En la columna de compra debe colocar el ID o Nro de la compra.</h2>  
                        <h2 class="text-sm ml-2 mb-1 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Mantener el nombre de las columnas como se encuentran.</h2>  
                        <hr>
                        @endif

                        @if ($vista == 'barra')
                            <form action="{{route('productos.productos.store')}}" method="POST" enctype="multipart/form-data">
                        @else
                            <form action="{{route('productos.serial.store')}}" method="POST" enctype="multipart/form-data">
                        @endif

                            @csrf

                            <input type="file" name="import_file">
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