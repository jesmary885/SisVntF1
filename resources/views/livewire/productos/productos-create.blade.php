<div x-data="{vencimiento: @entangle('vencimiento'),act_utilidades: @entangle('act_utilidades'),tipo_pago: @entangle('tipo_pago')}">
    <div class="card">
        <h5 class="modal-title py-0 text-lg text-gray-800 ml-4"> <i class="fas fa-database"></i>  Registro de producto</h5>
    </div>

    <div class="card w-full pt-0 m-0">
        <div class="card-body w-full pt-0 mt-0">
            <div class="flex justify-between">
                <div class="mt-2 ">
                    <h2 class="text-sm ml-2 m-0 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Complete todos los campos y presiona Guardar</h2>
                    <h2 class="text-sm ml-2 m-0 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> El código de barra debe tener mínimo 8 y máximo 12 caracteres</h2> 
                    <h2 class="text-sm ml-2 m-0 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Campos opcionales: Observaciones e imágen</h2>  
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
                    <div class="flex">
                        <div class="bg-green-200 w-6 h-6"></div>
                        <p class="text-gray-500 ml-2 font-semibold">Precios por combo</p>
                    </div>
                    
               
                </div>

            </div>
            
            <hr>
            <div class="flex">
                <i class="fas fa-barcode mt-1 mr-2"></i>
                <h2 class="text-lg inline mt-0">Información del producto</h2>
            </div>
            <div class="flex mt-2 mr-2">
                <div class="w-3/4">
                    <input wire:model.defer="nombre" type="text" class="px-2 appearance-none block w-full text-gray-700 bg-gray-50 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Nombre del producto">
                    <x-input-error for="nombre" />
                </div>
                <div class="w-1/4">
                    <input wire:model.defer="cod_barra" type="text" class="px-2 appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 ml-2" placeholder="Código de barra">
                    <x-input-error for="cod_barra" />
                </div>
            </div>

            <div class="flex justify-between w-full mt-3">
                <div class="w-full mr-2">
              

                    <select wire:model.lazy="categoria_id" class="block w-full bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        <option value="" selected>Seleccione la categoría</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                        @endforeach
                    </select>
                    <x-input-error for="categoria_id" />
                </div>
                <div class="w-full mr-2">
                        <select wire:model.lazy="marca_id" class="block w-full bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="" selected>Seleccione la marca</option>
                            @foreach ($marcas as $marca)
                                <option value="{{$marca->id}}">{{$marca->nombre}}</option>
                            @endforeach
                        </select>
                        <x-input-error for="marca_id" />
                </div>
                <div class="w-full">
                        <select wire:model.lazy="modelo_id" class="block w-full bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="" selected>Seleccione la presentación</option>
                            @foreach ($modelos as $modelo)
                                <option value="{{$modelo->id}}">{{$modelo->nombre}}</option>
                            @endforeach
                        </select>
                        <x-input-error for="modelo_id" />
                </div>
            </div>

            <hr class="mb-2">

            <div class="flex">
                <i class="fas fa-luggage-cart mt-1 mr-2"></i>
                <h2 class="text-lg">Cantidades y presentación</h2>
            </div>

            <div class="flex w-full mt-3 mr-2">
                <div class="w-1/4 mr-2">
                    <input wire:model="cantidad" type="number" min="0" class="w-full px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Cantidad">
                    <x-input-error for="cantidad" />
                </div>

                <div class="w-1/4 mr-2">
                    <input wire:model.defer="stock_minimo" type="number" class="w-full px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Stock minimo">
                    <x-input-error for="stock_minimo" />
                </div>

                <div class="w-1/2">
                <select wire:model.defer="presentacion" id="presentacion" class="block w-full bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="presentación">
                        <option value="" selected>Seleccione la presentación</option>
                        <option value="Unidad">Unidad</option>
                        <option value="Libra">Libra</option>
                        <option value="Kilogramos">Kilogramos</option>
                        <option value="Caja">Caja</option>
                        <option value="Paquete">Paquete</option>
                        <option value="Lata">Lata</option>
                        <option value="Galon">Galon</option>
                        <option value="Botella">Botella</option>
                        <option value="Tira">Tira</option>
                        <option value="Sobre">Sobre</option>
                        <option value="Saco">Saco</option>
                        <option value="Tarjeta">Tarjeta</option>
                        <option value="Otros">Otros</option>
                    </select>
                    <x-input-error for="presentacion" />
                </div>
             
            </div>

            <hr class="mb-2">

            <div class="flex">
                <i class="fas fa-calculator mt-1 mr-2 ml-  "></i>
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
                        <div class="w-full mr-2 mt-4 bg-green-200">
                            <div class="flex">
                                <div class="flex-1">
                                    <input wire:model="precio_combo" title="Precio al mayor" readonly type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Combo">
                                </div>
                                <p class="p-0 my-0 text-gray-800 mr-2">{{$moneda_select}}</p>
                            </div>
                            
                            <x-input-error for="precio_combo" />
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 w-full">
                <h2 class="w-full text-center text-md font-semibold text-gray-600 ">Utilidad</h2>
                   
                    <div class="mt-2">
                        <div class="w-full mr-2 bg-blue-200">
                            <div class="flex">
                                <div class="flex-1" :class="{'hidden' : act_utilidades != '1'}">
                                    <input wire:model="utilidad_letal" readonly title="Utilidad detal" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200  py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Unitario">
                                </div>

                                <div class="flex-1" :class="{'hidden' : act_utilidades == '1'}">
                                    <input wire:model="utilidad_letal" title="Utilidad detal" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Unitario">
                                </div>
                                <p class="p-0 my-0 text-gray-800 mr-2">{{$moneda_select}}</p>
                            </div>
                            
                            <x-input-error for="utilidad_letal" />
                        </div>
                        <div class="w-full bg-yellow-200 mr-2 mt-4">
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
                        <div class="w-full bg-green-200 mr-2 mt-4">
                            <div class="flex">
                                <div class="flex-1" :class="{'hidden' : act_utilidades != '1'}">
                                    <input wire:model="utilidad_combo" readonly title="Utilidad por combo" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Combo">
                                </div>
                                <div class="flex-1" :class="{'hidden' : act_utilidades == '1'}">
                                    <input wire:model="utilidad_combo" title="Utilidad por combo" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Combo">
                                </div>
                                <p class="p-0 my-0 text-gray-800 mr-2">{{$moneda_select}}</p>
                            </div>
                            
                            <x-input-error for="utilidad_combo" />
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
                                    <input wire:model="margen_letal" title="Margen de ganancia detal" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Unitario">
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
                        <div class="w-full mt-4 bg-green-200">
                            <div class="flex">
                                <div class="flex-1" :class="{'hidden' : act_utilidades != '2'}">
                                    <input wire:model="margen_combo" readonly title="Margen de ganancia por combo" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Combo">
                                </div>
                                <div class="flex-1" :class="{'hidden' : act_utilidades == '2'}">
                                    <input wire:model="margen_combo" title="Margen de ganancia por combo" type="number" min="0" class="w-5/6 px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Combo">
                                </div>
                                <p class="p-0 my-0 text-gray-800 font-semibold mr-2">%</p>
                            </div>
                            <x-input-error for="margen_combo" />
                        </div>
                    </div>
                </div>
            </div>

            <hr class="mb-2">

            <div class="flex">
                <i class="fas fa-balance-scale-left mt-1 mr-2"></i>
                <h2 class="text-lg">Información sobre descuento e impuesto</h2>
            </div>

            <div class="flex w-full mr-2">

                <div class="w-1/4 mr-2 mt-3">
                    <input wire:model.defer="descuento" type="text" class="w-full px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Descuento (%) en venta">
                    <x-input-error for="descuento" />
                </div>

                <div class="flex ml-4">
                    <input type="checkbox" class="mt-2" wire:model="exento" value="1">
                    <p class="text-sm font-semibold text-gray-500 ml-2 mt-4">Exento de IVA</p>
                </div>
            </div>

            <hr class="mb-2">

            <div class="flex">
                <i class="fas fa-calendar-alt mt-1 mr-2"></i>
                <h2 class="text-lg">Vencimiento del producto</h2>
            </div>

            <div class="flex w-1/2">
                <div class="w-1/4">
                    <div class="flex">
                        <input type="radio" class=" ml-1" wire:model="vencimiento" value="si">
                        <p class="text-sm font-semibold text-gray-500 ml-2 mt-3">Si vence</p>
                    </div>
                    <div class="flex">
                        <input type="radio" class=" ml-1" wire:model="vencimiento" value="no">
                        <p class="text-sm font-semibold text-gray-500 ml-2 mt-3">No vence</p>
                    </div>
                    <x-input-error for="vencimiento" />
                </div>

                <div :class="{'hidden': (vencimiento != 'si')}" class="w-1/2 ml-2 mt-10">
                    <x-input.date wire:model.lazy="fecha_vencimiento" id="fecha_vencimiento" placeholder="Fecha de vencimiento" class="px-4 outline-none"/>
                    <x-input-error for="fecha_vencimiento"/>
                </div>
            </div>

            <hr class="mb-2">

         
            <div class="flex mt-4">
                <i class="fas fa-history mt-3 mr-2"></i>
                <h2 class="text-lg inline mt-2 underline decoration-gray-400">Garantia de fabrica</h2>
            </div>

            <div class="flex justify-start w-full mt-3">
                <div class="W-1/4 mr-2">
                    <select id="tipo_garantia" wire:model.lazy="tipo_garantia" class="block w-full bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="tipo_garantia">
                        <option value="" selected>Unidad de tiempo</option>
                        <option value="N/A">N/A</option>
                        <option value="Semanas">Semanas</option>
                        <option value="Mes">Mes</option>
                        <option value="Meses">Meses</option>
                        <option value="Ano">Ano</option>
                        <option value="Anos">Anos</option>
                    </select>
                    <x-input-error for="tipo_garantia" />
                </div>
                <div class="W-1/4 mr-2">
                    <input wire:model="unidad_tiempo_garantia" type="number" class="w-full px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Tiempo de garantia">
                    <x-input-error for="unidad_tiempo_garantia" />
                </div>
            </div> 

            <hr class="mb-2">
      
            <div class="flex ">
                <i class="fas fa-truck-loading mt-2 mr-2"></i>
                <h2 class="text-lg inline mt-0">Proveedor e información de almacenamiento</h2>
            </div>

            <div class="flex justify-start w-full mt-3">
                <div class="w-full mr-2">
                    <select wire:model.defer="proveedor_id" class="block w-full bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        <option value="" selected>Seleccione el proveedor</option>
                        @foreach ($proveedores as $proveedor)
                            <option value="{{$proveedor->id}}">{{$proveedor->nombre_proveedor}}</option>
                        @endforeach
                    </select>
                    <x-input-error for="proveedor_id" />
                </div> 
      
                <div class="w-full mr-2">
                    @if ($limitacion_sucursal)
                        <select wire:model.lazy="sucursal_id" class="block w-full bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="" selected>Seleccione el almacen</option>
                            @foreach ($sucursales as $sucursal)
                                <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="text" readonly value="Sucursal {{$sucursal_nombre}}" class="w-full px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" >
                    @endif   
                    <x-input-error for="sucursal_id" />
                </div>
                <div class="w-full">
                  
                    <select id="estado" wire:model.defer="estado" class="block w-full bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="estado">
                        <option value="" selected>Estado del producto</option>
                        <option value="Habilitado">Habilitado</option>
                        <option value="Deshabilitado">Deshabilitado</option>
                    </select>
                    <x-input-error for="estado" />
                </div>
            </div>

            

            <hr>
            <div class="flex">
                <i class="fas fas fa-money-bill mt-2 mr-2"></i>
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
                <i class="far fa-image mt-2 mr-2"></i>
                <h2 class="text-lg inline mt-0">Foto o imagen del producto</h2>
            </div> 
              <div class="row">
                <div class="col">
                    <div class="w-50 h-50">         
                        @if ($file)
                        <img src="{{ $file->temporaryUrl() }}" width="75%" height="75%">
                        @endif
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <input type="file" wire:model="file" id="file" class="block w-full py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" accept="image/*">
                        @error('file')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                        <p>Tipos de archivos permitidos: JPG, JPEG, PNG. Tamaño máximo 3MB. Resolución recomendada 300px X 300px o superior.</p>
                    </div>
                </div>
            </div>
            
            <hr class="mb-2">
         
            <div class="flex">
                <i class="fas fa-edit mt-2 mr-2"></i>
                <h2 class="text-lg inline mt-0">Observaciones</h2>
            </div> 

            <div>
                <textarea wire:model.defer="observaciones" class="mt-2 resize-none rounded-md outline-none w-full px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="observaciones" cols="80" rows="2" required placeholder="Observaciones"></textarea>
                <x-input-error for="observaciones" />
            </div>

             {{-- <div class="row">
                <div class="col">
                    <div class="w-50 h-50">         
                        
                        <img id="picture" src="https://cdn.pixabay.com/photo/2020/12/13/16/21/stork-5828727_960_720.jpg" alt="">
                     
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <input type="file" id="file" class="form-control-file" accept="image/*">
                        @error('file')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Facere repudiandae eius obcaecati ipsam error quas? Explicabo maiores sapiente recusandae, odio accusamus amet saepe error, deleniti doloribus expedita et natus consequuntur.</p>
                    </div>
                </div>
            </div>  --}}

            <hr>
       
            <div class="mt-4">
                <button type="submit" class="btn btn-primary" wire:click="save">
                    <i class="fas fa-file-download"></i> Guardar
                </button>
                <a href="{{route('productos.productos.index')}}" class="btn btn-primary"><i class="fas fa-undo-alt"></i> Regresar</a>
            </div>
        </div>
    </div>
</div>



        





