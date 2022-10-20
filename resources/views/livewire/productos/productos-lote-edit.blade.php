<div x-data="{vencimiento: @entangle('vencimiento'),act_utilidades: @entangle('act_utilidades')}">
     <button title="Editar lote" type="submit" class="btn btn-success btn-sm" wire:click="open">
        <i class="fas fas fa-edit"></i>
    </button> 

    @if($isopen)
    
    <div class="modal d-block" tabindex="-1" role="dialog" style="overflow-y: auto; display: block;" wire:click.self="$set('isopen', false)">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title py-0 text-lg text-gray-800"><i class="fas fas fa-boxes"></i> Editar lote Nro {{$nro_lote}} de producto "{{$nombre}}" con código de barra {{$cod_barra}}</h5>
             
            </div>
            <div class="modal-body">
                <div class="flex justify-between">
                    <div>
                    <h2 class="text-sm ml-2 mb-2 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Complete todos los campos y presiona Guardar</h2> 
                    <h2 class="text-sm ml-2 mb-2 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Para procesar la modificación de cantidades debe hacer click en <i class="fas fa-edit"></i> ubicado al lado de la cantidad modificada</h2> 
                    <h2 class="text-sm ml-2 mb-2 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Si modifica alguna cantidad, o precio de compra, debe recordar modificar también la compra, ubicada en el menú "Administración->Compras"</h2> 
                    </div>

                    <div class="mt-2">
                        <div class="flex">
                            <div class="bg-blue-200 w-6 h-6"></div>
                            <p class="text-gray-500 text-sm ml-2 font-semibold">Precios Unitarios</p>
                        </div>
                        <div class="flex">
                            <div class="bg-yellow-200 w-6 h-6"></div>
                            <p class="text-gray-500 text-sm ml-2 font-semibold">Precios al mayor</p>
                        </div>
                    </div>
                </div>

                <hr class="m-0 p-0">
                       
                <div class="flex mt-2">
                        <i class="fas fa-calculator mt-1 mr-2"></i>
                        <h2 class="text-lg">Calculo de Precio, margen y utilidad</h2>
                </div>
                <div class="grid lg:grid-cols-5 gap-4">

                    <div class="flex lg:col-span-1 justify-between w-full mr-2">
                        <div class="w-full mt-5">
                            <input wire:model="precio_entrada" type="number" min="0" class="w-full px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Precio de compra">
                            <x-input-error for="precio_entrada" />
                        </div>
                        <div class="w-1/3 mt-5">
                            <select wire:model.lazy="moneda_id" class="block w-full bg-gray-50 border border-gray-200 text-gray-400 py-1 px-1 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        
                                @foreach ($monedas as $moneda)
                                    <option value="{{$moneda->id}}">{{$moneda->simbolo}}</option>
                                @endforeach
                            </select>
                            <x-input-error for="moneda_id" />
                        </div>
                    </div>

                    <div class="lg:col-span-1 w-full mt-3">
                        <!-- <div class="w-1/4"> -->
                            <div class="flex">
                                <input type="radio" class=" ml-1" wire:model="act_utilidades" value="1">
                                <p class="text-sm font-semibold text-gray-500 ml-2 mt-3">Calcular precio + Utilidad</p>
                            </div>
                            <div class="flex">
                                <input type="radio" class=" ml-1" wire:model="act_utilidades" value="2">
                                <p class="text-sm font-semibold text-gray-500 ml-2 mt-3">Calcular precio + Margen</p>
                            </div>
                        <!-- </div> -->
                    </div>

                    <div class="lg:col-span-1 w-full">
                                        
                        <h2 class="w-full text-center text-md font-semibold text-gray-600 ">Precio</h2>
                                    
                        <div class="mt-2">
                            <div class="w-full mr-2 bg-blue-200">
                                <input wire:model="precio_letal" title="Precio Unitario" readonly type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Unitario">
                                <x-input-error for="precio_letal" />
                            </div>
                            <div class="w-full mr-2 mt-4 bg-yellow-200">
                                <input wire:model="precio_mayor" title="Precio al mayor" readonly type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Mayor">
                                <x-input-error for="precio_mayor" />
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1 w-full">
                    <h2 class="w-full text-center text-md font-semibold text-gray-600 ">Utilidad</h2>
                                    
                        <div class="mt-2">
                            <div class="w-full mr-2 bg-blue-200">
                                <div :class="{'hidden' : act_utilidades != '1'}">
                                    <input wire:model="utilidad_letal" readonly title="Utilidad letal" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Unitario">
                                </div>

                                <div :class="{'hidden' : act_utilidades == '1'}">
                                    <input wire:model="utilidad_letal" title="Utilidad letal" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Unitario">
                                </div>
                                <x-input-error for="utilidad_letal" />
                            </div>
                            <div class="w-full mr-2 mt-4 bg-yellow-200">
                                <div :class="{'hidden' : act_utilidades != '1'}">
                                    <input wire:model="utilidad_mayor" readonly title="Utilidad al mayor" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Mayor">
                                </div>
                                <div :class="{'hidden' : act_utilidades == '1'}">
                                    <input wire:model="utilidad_mayor" title="Utilidad al mayor" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Mayor">
                                </div>
                                <x-input-error for="utilidad_mayor" />
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1 w-full">
                        <h2 class="w-full text-center text-md font-semibold text-gray-600 ">Margen de ganancia</h2>
                                    
                        <div class="mt-2">
                            <div class="w-full bg-blue-200">
                                <div :class="{'hidden' : act_utilidades != '2'}">
                                    <input wire:model="margen_letal" readonly title="Margen de ganancia letal" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Unitario">
                                </div>
                                    <div :class="{'hidden' : act_utilidades == '2'}">
                                        <input wire:model="margen_letal" title="Margen de ganancia letal" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Unitario">
                                    </div>
                                    <x-input-error for="margen_letal" />
                                </div>
                                <div class="w-full mt-4 bg-yellow-200">
                                    <div :class="{'hidden' : act_utilidades != '2'}">
                                        <input wire:model="margen_mayor" readonly title="Margen de ganancia al mayor" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Mayor">
                                    </div>
                                    <div :class="{'hidden' : act_utilidades == '2'}">
                                        <input wire:model="margen_mayor" title="Margen de ganancia al mayor" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Mayor">
                                    </div>
                                    <x-input-error for="margen_mayor" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div :class="{'hidden': vencimiento == 'No'}" class="w-full ml-2 mt-4 mb-2">
                        <hr class="mb-2">

                        <div class="w-1/3 mb-4">
                            <div class="flex">
                                <i class="fas fa-calendar-alt mt-1 mr-2"></i>
                                <h2 class="text-lg mb-4">Vencimiento del producto</h2>
                            </div>

                            <x-input.date wire:model.lazy="fecha_vencimiento" id="fecha_vencimiento" placeholder="Fecha de vencimiento" class="px-4 outline-none"/>
                            <x-input-error for="fecha_vencimiento"/>

                        </div>
                    </div>

                    <hr class="m-0 p-0">

                    <div class="flex mt-2 mb-2">
                        <i class="fas fa-box-open mt-1 mr-2 mb-2"></i>
                        <h2 class="text-lg">Cantidad</h2>
                    </div>

                    <div class="w-full mr-2 ml-2">
                        @foreach ($sucursal_lote_productos as $sucursal_lote_producto)
                            <div class="flex w-1/3 justify-between">
                                <div class="flex-1">
                                    <p>Sucursal {{$sucursal_lote_producto->sucursal->nombre}}</p>
                                </div>
                                <div>
                                <td width="10px">
                                         @livewire('productos.productos-lote-cant-edit', ['lote' => $sucursal_lote_producto],key(01.,'$sucursal_lote_producto->->id'))
                                    </td>
                                </div>
                                
                            </div>
                        @endforeach
                    </div>

                    

                    <hr class="m-0 p-0">

                    <div class="flex mt-2">
                        <i class="fas fa-calculator mt-1 mr-2 mb-2"></i>
                        <h2 class="text-lg">Observaciones, estatus y proveedor</h2>
                    </div>

                    <div class="flex justify-between w-full mr-2">
                        <div class="flex-1">
                            <textarea wire:model="observaciones" title="Observaciones" class="mt-2 resize-none rounded-md outline-none w-full px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="observaciones" cols="80" rows="2" required placeholder="Observaciones"></textarea>
                            <x-input-error for="observaciones" />
                        </div>
                        <div>
                            <select id="status" wire:model.lazy="status" title="Estado del lote" class=" mt-3 mr-2 ml-2 block w-full bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="estado">
                                <option value="" selected>Estado del lote</option>
                                <option value="activo">Habilitado</option>
                                <option value="inactivo">Deshabilitado</option>
                                </select>
                            <x-input-error for="estado" />
                        </div>
             
                        <div class="ml-2">
                                <select wire:model="proveedor_id" title="Proveedor" class="mr-1 mt-3 ml-2 block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="" selected>Seleccione el proveedor</option>
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
              <button type="button" class="btn btn-primary" wire:click="update">Guardar</button>
            </div>
          </div>
        </div>
    </div>

    @endif
</div>
