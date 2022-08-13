<div>
    <button type="submit" class="btn btn-primary btn-sm" title="Editar compra" wire:click="open">
        <i class="fas fa-edit"></i>
   </button> 

   @if($isopen)
        <div class="modal d-block" tabindex="-1" role="dialog" style="overflow-y: auto; display: block;" wire:click.self="$set('isopen', false)">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title py-0 text-lg text-gray-800"> <i class="fas fa-shopping-bag"></i>  Editar compra</h5>
                    </div>
                    <div class="modal-body"><h2 class="text-sm ml-2 m-0 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Complete todos los campos y presiona Guardar</h2> 
                        
                        <div class="flex mt-2 justify-between w-full">
                            <div class="w-full mr-2">
                                <input wire:model.defer="cantidad" title="Cantidad" name="documento" type="text" class="px-2 appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Cantidad">
                                <x-input-error for="cantidad" />
                            </div>
                            <div class="w-full">
                                @if ($limitacion_sucursal)
                                    <select wire:model="sucursal_id" title="Sucursal" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <option value="" selected>Almacen</option>
                                        @foreach ($sucursales as $sucursal)
                                            <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text" readonly value="Sucursal {{$sucursal_nombre}}" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" >
                                @endif   
                                <x-input-error for="sucursal_id" />
                            </div>
                          
                        </div>
                        <div class="flex mt-2 ustify-between w-full">
                            <div class="w-full mr-2">
                                <input wire:model.defer="precio_compra" title="Precio de compra" name="documento" type="text" class="px-2 appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Precio de compra">
                                <x-input-error for="precio_compra" />
                            </div>
                            
                            <div class="w-full">
                                <select wire:model="proveedor_id" title="Proveedor" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="" selected>Proveedor</option>
                                    @foreach ($proveedores as $proveedor)
                                        <option value="{{$proveedor->id}}">{{$proveedor->nombre_proveedor}}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="proveedor_id" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close" >Cerrar</button>
                        <button type="button" class="btn btn-primary disabled:opacity-25" wire:loading.attr="disabled" wire:click="save">Guardar</button>
                    </div>
                </div>  
            </div>    
        </div>
   @endif
</div>
