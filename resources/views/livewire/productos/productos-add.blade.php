<div x-data="{vencimiento: @entangle('vencimiento'),act_utilidades: @entangle('act_utilidades'),lote_id: @entangle('lote_id'),saldado_proveedor: @entangle('saldado_proveedor'),tipo_pago: @entangle('tipo_pago')}">
    <button type="submit" class="btn btn-primary btn-sm" title="Añadir productos" wire:click="open">
        <i class="fas fa-plus-square"></i>
   </button> 

   @if($isopen)
        <div class="modal d-block" tabindex="-1" role="dialog" style="overflow-y: auto; display: block;" wire:click.self="$set('isopen', false)">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="flex justify-between w-full">
                            <div class="flex-1">
                                <h5 class="modal-title py-0 text-lg text-gray-800"> <i class="fas fa-database"></i>  Agregar unidades al producto</h5>
                            </div>
                            <button type="button" class="btn" data-dismiss="modal" wire:click="close"><i class="fas fa-window-close"></i></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        
                        <div class="flex justify-between">
                            <div>
                                <h2 class="text-sm ml-2 m-0 p-0 text-gray-500 font-semibold mb-4"><i class="fas fa-info-circle"></i> Complete todos los campos y presiona Guardar</h2> 
                            </div>
                            <div class="mt-2">
                                <div class="flex">
                                    <div class="bg-blue-200 w-6 h-6"></div>
                                    <p class="text-gray-500 ml-2 font-semibold">Precios Unitarios</p>
                                </div>
                                <div class="flex">
                                    <div class="bg-yellow-200 w-6 h-6"></div>
                                    <p class="text-gray-500 ml-2 font-semibold">Precios al mayor</p>
                                </div>

                            </div>
                        </div>

                        <hr>

                        <div class="flex mt-2 justify-between w-full">
                            
                            <div class="w-full mr-2">
                                @if ($limitacion_sucursal)
                                    <select wire:model="sucursal_id" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <option value="" selected>Almacen</option>
                                        @foreach ($sucursales as $sucursal)
                                            <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="sucursal_id" />
                                @else
                                    <input type="text" readonly value="Sucursal {{$sucursal_nombre}}" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" >
                                @endif  
                            </div>

                            <div class="w-full">
                                    <select wire:model="proveedor_id" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <option value="" selected>Proveedor</option>
                                        @foreach ($proveedores as $proveedor)
                                            <option value="{{$proveedor->id}}">{{$proveedor->nombre_proveedor}}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="proveedor_id" />
                            </div>

                            
                        </div>

                        <div class="flex mt-2 justify-between w-full">
                            <div class="w-full">
                                    <select wire:model="lote_id" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <option value="" selected>Lote</option>
                                        @foreach ($lotes as $lote)
                                            <option value="{{$lote->lote}}">{{$lote->lote}}</option>
                                        @endforeach
                                        <option value="nuevo_lote">Nuevo lote</option>
                                    </select>
                                    <x-input-error for="lote_id" />
                            </div>

                            <div class="w-full ml-2">
                                    <input wire:model="cantidad" name="documento" type="number" min="0" class="px-4 appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Cantidad">
                                    <x-input-error for="cantidad" />
                            </div>

                           
                        </div>
                       

                        <hr>
            
                        
                        <div :class="{'hidden': (lote_id != 'nuevo_lote')}" >
                                <hr class="mb-2">
                                <div class="flex">
                                    <i class="fas fa-calculator mt-1 mr-2"></i>
                                    <h2 class="text-lg">Calculo de Precio, margen y utilidad</h2>
                                </div>
                                <div class="grid lg:grid-cols-5 gap-4">

                                    <div class="lg:col-span-1 justify-between w-full mr-2">

                                    <div class="flex">
                                        <div class="w-full mt-5">
                                            <input wire:model="precio_entrada" type="number" min="0" class="w-full px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Precio de compra">
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

                                    <div class="mt-3 w-full ml-2">
                    
                                        <p class="text-gray-800 font-semibold">Total: {{$total_pagar}} {{$moneda_select}}</p>
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
                                                <div class="flex">
                                                    <div class="flex-1">
                                                        <input wire:model="precio_letal" title="Precio Unitario" readonly type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Unitario">
                                                    </div>
                                                    <p class="p-0 my-0 text-gray-800 mr-2">{{$moneda_select}}</p>
                                                </div>
                                                
                                                
                                                <x-input-error for="precio_letal" />
                                            </div>
                                            <div class="w-full mr-2 mt-4 bg-yellow-200">
                                                <div class="flex">
                                                    <div class="flex-1">
                                                        <input wire:model="precio_mayor" title="Precio al mayor" readonly type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Mayor">
                                                    </div>
                                                    <p class="p-0 my-0 text-gray-800 mr-2">{{$moneda_select}}</p>
                                                </div>
                                                
                                                
                                                <x-input-error for="precio_mayor" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="lg:col-span-1 w-full">
                                    <h2 class="w-full text-center text-md font-semibold text-gray-600 ">Utilidad</h2>
                                    
                                        <div class="mt-2">
                                            <div class="w-full mr-2 bg-blue-200">
                                                <div class="flex">
                                                    <div class="flex-1" :class="{'hidden' : act_utilidades != '1'}">
                                                        <input wire:model="utilidad_letal" readonly title="Utilidad letal" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Unitario">
                                                    </div>

                                                    <div class="flex-1" :class="{'hidden' : act_utilidades == '1'}">
                                                        <input wire:model="utilidad_letal" title="Utilidad letal" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Unitario">
                                                    </div>
                                                    <p class="p-0 my-0 text-gray-800 mr-2">{{$moneda_select}}</p>
                                                </div>
                                                
                                                <x-input-error for="utilidad_letal" />
                                            </div>
                                            <div class="w-full mr-2 mt-4 bg-yellow-200">
                                                <div class="flex">
                                                    <div class="flex-1" :class="{'hidden' : act_utilidades != '1'}">
                                                        <input wire:model="utilidad_mayor" readonly title="Utilidad al mayor" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Mayor">
                                                    </div>
                                                    <div class="flex-1" :class="{'hidden' : act_utilidades == '1'}">
                                                        <input wire:model="utilidad_mayor" title="Utilidad al mayor" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Mayor">
                                                    </div>
                                                    <p class="p-0 my-0 text-gray-800 mr-2">{{$moneda_select}}</p>
                                                </div>
                                                
                                                <x-input-error for="utilidad_mayor" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="lg:col-span-1 w-full">
                                        <h2 class="w-full text-center text-md font-semibold text-gray-600 ">Margen de ganancia</h2>
                                    
                                        <div class="mt-2">
                                            <div class="w-full bg-blue-200">
                                                <div class="flex">
                                                    <div class="flex-1" :class="{'hidden' : act_utilidades != '2'}">
                                                        <input wire:model="margen_letal" readonly title="Margen de ganancia letal" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Unitario">
                                                    </div>
                                                    <div class="flex-1" :class="{'hidden' : act_utilidades == '2'}">
                                                        <input wire:model="margen_letal" title="Margen de ganancia letal" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Unitario">
                                                    </div>
                                                    <p class="p-0 my-0 text-gray-800 font-semibold mr-2">%</p>

                                                </div>
                                                
                                                <x-input-error for="margen_letal" />
                                            </div>
                                            <div class="w-full mt-4 bg-yellow-200">
                                                <div class="flex">
                                                    <div class="flex-1" :class="{'hidden' : act_utilidades != '2'}">
                                                        <input wire:model="margen_mayor" readonly title="Margen de ganancia al mayor" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Mayor">
                                                    </div>
                                                    <div class="flex-1" :class="{'hidden' : act_utilidades == '2'}">
                                                        <input wire:model="margen_mayor" title="Margen de ganancia al mayor" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Mayor">
                                                    </div>
                                                    <p class="p-0 my-0 text-gray-800 font-semibold mr-2">%</p>

                                                </div>
                                                
                                                <x-input-error for="margen_mayor" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div :class="{'hidden': vencimiento != 'si'}" class="w-1/3 ml-2 mt-4">
                                    <hr class="mb-2">
                                    <div class="flex">
                                        <i class="fas fa-calendar-alt mt-1 mr-2"></i>
                                        <h2 class="text-lg">Vencimiento del producto</h2>
                                    </div>
                                    <x-input.date wire:model.lazy="fecha_vencimiento" id="fecha_vencimiento" placeholder="Fecha de vencimiento" class="px-4 outline-none"/>
                                    <x-input-error for="fecha_vencimiento"/>
                                </div>
                        </div>
                        
                        <div :class="{'hidden': (lote_id == '')}" >
                            <div :class="{'hidden': (lote_id == 'nuevo_lote')}" >
                                <hr class="mb-2">
                                <div class="flex">
                                    <i class="fas fa-calculator mt-1 mr-2"></i>
                                    <h2 class="text-lg">Precio, margen y utilidad</h2>
                                </div>
                                <div class="grid lg:grid-cols-4 gap-4">
                                

                                    <div class="lg:col-span-1 w-full mr-2">
                                        <div class="w-full mt-5 flex justify-between">
                                       
                                                <div>
                                                    <input readonly wire:model="precio_entrada" type="number" min="0" class="px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Precio de compra">
                                                </div>
                                                <div class="w-1/3 ml-2 mt-1">
                                                    <p class="font-semibold  text-gray-500">{{ $moneda_lote }}</p>
                                                </div>
                                        
                                            
                                        </div>
                                        <div class="mt-3 w-full ml-2">
                    
                                                <p class="text-gray-800 font-semibold">Total: {{$total_pagar}} {{$moneda_lote}}</p>
                                            </div>
                                    </div>

                                    <div class="lg:col-span-1 w-full">
                                        
                                            <h2 class="w-full text-center text-md font-semibold text-gray-600 ">Precio</h2>
                                    
                                        <div class="mt-2">
                                            <div class="w-full mr-2 bg-blue-200">
                                                <div class="flex">
                                                    <div class="flex-1">
                                                        <input wire:model="precio_letal" title="Precio Unitario" readonly type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Unitario">
                                                    </div>
                                                    <p class="p-0 my-0 text-gray-800 mr-2">{{$moneda_select}}</p>
                                                </div>
                                                    
                                                
                                            </div>
                                            <x-input-error for="precio_letal" />
                                            <div class="w-full mr-2 mt-4 bg-yellow-200">
                                                <div class="flex" >
                                                    <div class="flex-1">
                                                        <input wire:model="precio_mayor" title="Precio al mayor" readonly type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Mayor">
                                                    </div>
                                                    <p class="p-0 my-0 text-gray-800 mr-2">{{$moneda_select}}</p>
                                                </div>
                                                
                                            </div>
                                            <x-input-error for="precio_mayor" />                                          
                                        </div>
                                    </div>

                                    <div class="lg:col-span-1 w-full">
                                        <h2 class="w-full text-center text-md font-semibold text-gray-600 ">Utilidad</h2>
                                    
                                        <div class="mt-2">
                                            <div class="w-full mr-2 bg-blue-200">
                                                <div class="flex">
                                                    <div class="flex-1">
                                                        <input readonly wire:model="utilidad_letal" title="Utilidad detal" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Unitario">
                                                    </div>
                                                    <p class="p-0 my-0 text-gray-800 mr-2">{{$moneda_select}}</p>
                                                </div>
                                                <x-input-error for="utilidad_letal" />
                                            </div>
                                            <div class="w-full mr-2 mt-4 bg-yellow-200">
                                                <div class="flex">
                                                    <div class="flex-1">
                                                        <input readonly wire:model="utilidad_mayor" title="Utilidad al mayor" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Mayor">
                                                    </div>
                                                    <p class="p-0 my-0 text-gray-800 mr-2">{{$moneda_select}}</p>
                                                </div>
                                                <x-input-error for="utilidad_mayor" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="lg:col-span-1 w-full">
                                        <h2 class="w-full text-center text-md font-semibold text-gray-600 ">Margen de ganancia</h2>
                                        <div class="mt-2">
                                            <div class="w-full bg-blue-200">
                                                <div class="flex">
                                                    <div class="flex-1">
                                                        <input wire:model="margen_letal" readonly title="Margen de ganancia detal" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Unitario">
                                                    </div>
                                                    <p class="p-0 my-0 text-gray-800 font-semibold mr-2">%</p>
                                                </div>
                                                <x-input-error for="margen_letal" />
                                            </div>
                                            <div class="w-full mt-4 bg-yellow-200">
                                                <div class="flex">
                                                    <div class="flex-1">
                                                        <input wire:model="margen_mayor" title="Margen de ganancia al mayor" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Mayor">
                                                    </div>
                                                    <p class="p-0 my-0 text-gray-800 font-semibold mr-2">%</p>
                                                </div>
                                                <x-input-error for="margen_mayor" />

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div :class="{'hidden': vencimiento != 'Si'}">
                                    <hr class="mb-2">
                                    <div class="flex">
                                        <i class="fas fa-calendar-alt mt-1 mr-2"></i>
                                        <h2 class="text-lg">Vencimiento del producto</h2>
                                    </div>

                                    <div class="w-1/3 ml-2 mt-4">
                                    <input readonly title="Fecha de vencimiento" wire:model.defer="fecha_vencimiento" name="fecha_vencimiento" type="text" class="px-4 appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <!-- <x-input wire:model.lazy="fecha_vencimiento" id="fecha_vencimiento" placeholder="Fecha de vencimiento" class="px-4 outline-none"/> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="flex mt-3 mb-2">
                <i class="fas fas fa-money-bill mt-1 mr-2"></i>
                <h2 class="text-lg inline mt-0">Información del pago</h2>
            </div>

            <select id="tipo_pago" wire:model.lazy="tipo_pago" class="block w-1/3 mr-2 bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="estado">
                        <option value="" selected>Tipo de pago</option>
                        <option value="1">Crédito con inicial</option>
                        <option value="2">Crédito sin inicial</option>
                        <option value="3">Contado</option>
                    </select>
            <x-input-error for="tipo_pago" />

            <div :class="{'hidden': (tipo_pago == '0')}" class="flex mt-2 justify-between w-full">
                <div :class="{'hidden': (tipo_pago == '2')}" class="flex mt-2 justify-between w-full">
                    <div class="w-1/2 mr-2">
                        <select wire:model.lazy="metodo_id" class="w-full mr-2 bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="0" selected>Seleccione el método pago</option>
                            @foreach ($metodos as $metodo)
                                <option value="{{$metodo->id}}">{{$metodo->nombre}}</option>
                            @endforeach
                        </select>
                        <x-input-error for="metodo_id" />
                    </div>

                    <div class="w-1/2 mr-2">
                        <select wire:model="caja_id" class="block mr-2 w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="" selected>Caja</option>
                                @foreach ($cajas as $caja)
                                    <option value="{{$caja->id}}">{{$caja->nombre}}</option>
                                @endforeach
                        </select>
                        <x-input-error for="caja_id" />
                    </div>
                            
                    <div class="w-1/2" :class="{'hidden': (tipo_pago != '1')}">
                        <input wire:model="pago" type="number" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Monto pagado">
                        <x-input-error for="pago" />
                    </div>
                </div>
            </div>

                        <hr class="mb-2">
                            <div class="flex">
                                <i class="fas fa-pencil-alt mt-1 mr-2"></i>
                                <h2 class="text-lg">Observaciones</h2>
                        </div>

                        <div>
                            <textarea wire:model="observaciones" class="mt-2 resize-none rounded-md outline-none w-full px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="observaciones" cols="80" rows="2" required placeholder="Observaciones"></textarea>
                            <x-input-error for="observaciones" />
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


