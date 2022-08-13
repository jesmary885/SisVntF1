<div>
    <button type="submit" class="btn btn-success btn-sm" title="Exportar a excel" wire:click="open">
    <i class="	fas fa-file-export"></i> Exportar inventario
   </button> 

   @if($isopen)
        <div class="modal d-block" tabindex="-1" role="dialog" style="overflow-y: auto; display: block;" wire:click.self="$set('isopen', false)">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title py-0 text-lg text-gray-800"><i class="far fa-file-excel"></i> Exportar inventario a Excel</h5>
                       
                    </div>
                    <div class="modal-body">
                        <h2 class="text-sm ml-2 m-0 p-0 text-gray-500 font-semibold mb-4"><i class="fas fa-info-circle"></i> Complete todos los campos y presiona Exportar</h2> 
                        <div class="flex mt-2 justify-between w-full">
                            <div class="w-full mr-2">
                                @if ($limitacion_sucursal)
                                    <select wire:model="sucursal_id" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <option value="" selected>Almacen</option>
                                        <option value="0">Todas las sucursales</option>
                                        @foreach ($sucursales as $sucursal)
                                            <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text" readonly value="Sucursal {{$sucursal_nombre}}" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" >
                                @endif   
                                <x-input-error for="sucursal_id" />
                            </div>
                            <div class="w-full">
                                <select id="estado" wire:model="estado" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="estado">
                                    <option value="" selected>Estado de los equipos</option>
                                    <option value="1">Todos</option>
                                    <option value="2">Habilitados</option>
                                    <option value="3">Deshabilitados</option>
                                </select>
                                <x-input-error for="estado" />

                            </div>

                            
                          
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close" >Cerrar</button>
                        <button type="button" class="btn btn-success disabled:opacity-25" wire:loading.attr="disabled" wire:click="export"><i class="far fa-file-excel"></i> Exportar</button>
                    </div>
                </div>
              
            </div>
            
        </div>
   @endif
</div>