<div x-data="{ ocultar_panel: @entangle('ocultar_panel'),publico_general: @entangle('publico_general'),tipo_pago: @entangle('tipo_pago'),metodo_pago: @entangle('metodo_pago'),siguiente_venta: @entangle('siguiente_venta'), imprimir: @entangle('imprimir'),tipo_comprobante: @entangle('tipo_comprobante'),carrito: @entangle('carrito'), cant_metodos: @entangle('cant_metodos'), vuelto: @entangle('vuelto')}">
    <section class="text-gray-700">
        <div>
            <p class="text-gray-500 text-lg font-semibold mt-2 mb-0 ml-2">
                Cliente:
            </p>
                <div class="flex">
                    <div class="flex w-full h-full ml-2 mt-0">
                        <input type="checkbox" class=" ml-1" wire:model="publico_general" value="1">
                        <p class="text-sm font-semibold text-gray-500 ml-2 mt-3">Público general</p>
                    </div>
                    
                    <div class="flex w-full h-full ml-2 mt-0" :class="{'hidden': (publico_general == '1')}">
                        <input type="checkbox" class=" ml-1" wire:model="ocultar_panel" value="1">
                        <p class="text-sm font-semibold text-gray-500 ml-2 mt-3">Ocultar panel de clientes
                    </div>
                    
                </div>

                <div :class="{'hidden': (publico_general == '1')}">
                    <div :class="{'hidden': (ocultar_panel == '1')}">
                        <div class="flex items-center justify-between m-0 bg-gray-300 mt-2 mb-2">
                            <div class="flex-1">
                                <input wire:model="search" placeholder="Seleccione el cliente o escriba aquí su nombre o nro documento" class="form-control">
                            </div>
                            <div class="ml-1">
                                @livewire('admin.clientes.clientes-create',['vista' => "ventas",'accion' => 'create'])
                            </div>
                        </div>
                        @if ($cliente != '0')
                            <div class="bg-white">
                                <table class="table table-striped table-responsive-sm">
                                    <thead >
                                        <tr>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">Documento</th>
                                        
                                            <th class="text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            
                                            <tr>
                                                <td class="text-center">{{$cliente->nombre}} {{$cliente->apellido}}</td>
                                                <td class="text-center">{{$cliente->nro_documento}}</td>
                                            
                                                <td width="10px">
                                                <button
                                                    class="ml-4 btn btn-primary btn-sm" title="Seleccionar cliente"
                                                    wire:click="select_u('{{$cliente->id}}}')">
                                                    <i class="fas fa-check"></i>
                                                </button>

                                                </td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                        
                        @else
                            <div class="card-body">
                                        
                            </div>
                        @endif
                    </div>
                </div>

        </div>

        @if (Cart::count())
            <hr>
            <p class="text-gray-500 text-lg font-semibold mt-2 mb-3 ml-2">
                    Productos incluidos en venta:
            </p>
            
            <div class="w-full overflow-auto h-48 bg-white">
                <table class="table table-bordered table-responsive-sm">
                    <thead class="sticky left-0 top-0">
                        <tr>
                            <th class="text-center  bg-white ">Cant</th>
                            <th class="text-center  bg-white">Producto</th>
                            <th class="text-center  bg-white">Subt</th>
                            <th class=" bg-white" colspan="1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Cart::content() as $item)
                            <tr class="overflow-hidden">
                                <td class="text-center text-sm  bg-white ">
                                    <span> {{ $item->qty }}</span>
                                </td>
                                
                                <td class="flex text-center text-sm  bg-white ">
                                @if($item->options['exento'] == "Si" )
                                <h3 class="mr-4 text-md text-gray-600">{{$item->name}} {{$item->options['modelo']}} (E)</h3>
                                @else
                                <h3 class="mr-4 text-md text-gray-600">{{$item->name}} {{$item->options['modelo']}}</h3>
                                @endif
                                </td>
                        
                                <td class="text-center text-sm bg-white">
                                    <span> {{ $moneda_simbolo }} {{  round($item->price / $tasa_dia,2) }}</span>
                                </td>
                            
                                <td class="text-center">
                                    <a class="text-center cursor-pointer hover:text-red-600"
                                        wire:click="delete('{{$item->rowId}}')"
                                        wire:loading.class="text-red-600 opacity-25"
                                        wire:target="delete('{{$item->rowId}}')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="flex justify-between p-2">
                <div>
                    <a class="text-sm cursor-pointer hover:underline inline-block"
                        wire:click="destroy">
                        <i class="fas fa-trash"></i>
                        Borrar todo
                    </a>
                </div>
            </div>
            <hr>
            <p class="text-gray-500 text-lg font-semibold mt-2 mb-3 ml-2">
                    Detalles del comprobante:
            </p>

      

            <div>
        
        
                <aside>
                    <div>
                        <div class="w-full">

                            <div class=" flex w-full ml-4 mt-0">
                                <p class="text-gray-500 font-semibold mr-2 ">Estado de entrega</p>
                                <div class="flex">
                                    <div>
                                    <input type="radio" wire:model="estado_entrega" class="mr-1" value="Entregado">
                                    </div> 
                                <p class="text-md font-semibold text-gray-500 mr-2">Entregado</p>
                                </div>
                                <div class="flex">
                                    <div>
                                        <input type="radio" wire:model="estado_entrega" class="mr-1" value="Por entregar">
                                    </div>
                                    <p class="text-md font-semibold text-gray-500 ml-1">Por entregar</p>
                                </div>
                            </div>

                            <div class=" flex w-full ml-4 mt-0">
                                        <p class="text-gray-500 font-semibold mr-5 ">Tipo de pago</p>
                                
                                        <div class="flex mr-3">
                                            <div >
                                            <input type="radio" class=" mr-1" wire:model="tipo_pago" value="contado">
                                            </div>
                                        
                                            <p class="text-md font-semibold text-gray-500 mr-2 ml-1">Contado</p>
                                        </div>

                                        <div class="flex">
                                            <div>
                                            <input type="radio" wire:model="tipo_pago" class="mr-1" value="credito">
                                            </div>
                                        
                                            <p class="text-md font-semibold text-gray-500 ml-1">Crédito</p>
                                        </div>

                            </div>
                            
                            

                            
                            
                            

                            <div class=" flex w-full ml-4 mt-0">
                                <p class="text-gray-500 font-semibold mr-4 ">Cambio a cliente</p>

                                <div class="flex">
                                    <div>
                                        <input type="radio" wire:model="vuelto" value="no">
                                    </div>
                                    <p class="text-md font-semibold text-gray-500 mr-2 ml-1">No</p>
                                </div>
                                    
                                <div class="flex">
                                    <div>
                                        <input type="radio"  wire:model="vuelto" value="si">
                                    </div>
                                    <p class="text-md font-semibold text-gray-500 ml-1">Sí</p>
                                </div>
                            </div>

                            <div class=" flex w-full ml-4 mt-0">
                                        <p class="text-gray-500 font-semibold mr-3">Métodos de pago</p>
                                        <div class="flex">
                                            <div >
                                            <input type="radio" class="ml-1 mr-1"  wire:model="cant_metodos" value="1">
                                            </div>
                                        
                                            <p class="text-md font-semibold text-gray-500 mr-4">1</p>
                                        </div>

                                        <div class="flex">
                                            <div>
                                            <input type="radio" wire:model="cant_metodos" value="2">
                                            </div>
                                        
                                            <p class="text-md font-semibold text-gray-500 ml-1 mr-4">2</p>
                                        </div>
                                        <div class="flex">
                                            <div >
                                            <input type="radio"  wire:model="cant_metodos" value="3">
                                            </div>
                                        
                                            <p class="text-md font-semibold text-gray-500 ml-1 mr-2">3</p>
                                        </div>
                            </div> 

                
                            <div class="flex w-full ml-4">
                                <p class="text-gray-500 font-semibold mr-3">Descuento en venta</p>
                                <div class="w-1/2">
                                    <input wire:model="descuento" type="number" min="0" title="Descuento en venta" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Descuento en %">
                                    <x-input-error for="descuento" />
                                </div>
                            </div>

                            {{--metodos de pago--}}

                            <div class="flex w-full ml-4 mb-2">
                            
                                <p class="text-gray-500 font-semibold mr-4">Métodos de pago</p>
                            
                                <div class="w-1/2 justify-start ml-2">
                                    {{--con 1 metodo--}}
                                    <div class="flex w-full ">
                                    
                                        <div class="w-1/2">
                                            <select wire:model.lazy="metodo_id_1" class="block bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                                <option value="" selected>Método 1</option>
                                                @foreach ($metodos as $metodo)
                                                    <option value="{{$metodo->id}}">{{$metodo->nombre}}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error for="metodo_id_1" />
                                        </div>

                                        <div class="w-1/2">
                                        
                                                <input wire:model="monto1" type="number" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Monto">
                                        
                                            <x-input-error for="monto1" />
                                        </div>
                                    </div>

                                    {{--con 2 metodos--}}
                                    <div :class="{'hidden': (cant_metodos == 1)}" class="flex w-full ">
                                        <div class="w-1/2">
                                            <select wire:model.lazy="metodo_id_2" class="block bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                                <option value="" selected>Método 2</option>
                                                @foreach ($metodos as $metodo)
                                                    <option value="{{$metodo->id}}">{{$metodo->nombre}}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error for="metodo_id_2" />
                                        </div>
                                        <div class="w-1/2">
                                            <input wire:model="monto2" type="number" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Monto recibido">
                                            <x-input-error for="monto2" />
                                        </div>
                                    </div>

                                    {{--con 3 metodos--}}
                                    <div :class="{'hidden': (cant_metodos == 1)}" >
                                        <div class="flex  w-full" :class="{'hidden': (cant_metodos == 2)}">
                                            <div class="w-1/2">
                                                <select wire:model.lazy="metodo_id_3" class="block bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                                    <option value="" selected>Método 3</option>
                                                    @foreach ($metodos as $metodo)
                                                        <option value="{{$metodo->id}}">{{$metodo->nombre}}</option>
                                                    @endforeach
                                                </select>
                                                <x-input-error for="metodo_id_3" />
                                            </div>
                                            <div class="w-1/2">
                                                <input wire:model="monto3" type="number" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Monto recibido">
                                                <x-input-error for="monto3" />
                                            </div>
                                        </div>
                                    </div>

                                    {{--con 4 metodos--}}
                                    <div :class="{'hidden': (cant_metodos == 1)}">
                                        <div :class="{'hidden': (cant_metodos == 2)}">
                                            <div :class="{'hidden': (cant_metodos == 3)}" class="flex w-full">
                                                <div class="w-1/2" >
                                                    <select wire:model.lazy="metodo_id_4" class="block bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                                        <option value="" selected>Método 4</option>
                                                        @foreach ($metodos as $metodo)
                                                            <option value="{{$metodo->id}}">{{$metodo->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                    <x-input-error for="metodo_id_4" />
                                                </div>
                                                <div class="w-1/2">
                                                    <input wire:model="monto4" type="number" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Monto recibido">
                                                    <x-input-error for="monto4" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--con 5 metodos--}}
                                    <div :class="{'hidden': (cant_metodos == 1)}" >
                                        <div :class="{'hidden': (cant_metodos == 2)}">
                                            <div :class="{'hidden': (cant_metodos == 3)}">
                                                <div :class="{'hidden': (cant_metodos == 4)}" class="flex w-full">
                                                    <div class="w-1/2">
                                                        <select wire:model.lazy="metodo_id_5" class="block bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                                            <option value="" selected>Método 5</option>
                                                            @foreach ($metodos as $metodo)
                                                                <option value="{{$metodo->id}}">{{$metodo->nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                        <x-input-error for="metodo_id_5" />
                                                    </div>
                                                    <div class="w-1/2">
                                                        <input wire:model="monto5" type="number" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Monto recibido">
                                                        <x-input-error for="monto5" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
                                    
                            </div>

                            <div :class="{'hidden': (vuelto == 'no')}" class="flex w-full ml-4">
                            
                                <p class="text-gray-500 font-semibold mr-3">Método de cambio</p>
                            
                                <div class="w-1/2 justify-start ml-2">
                                    <div class="flex w-full ">
                                    
                                        <div class="w-1/2">
                                            <select wire:model.lazy="metodo_cambio_id" class="block bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                                <option value="" selected>Método</option>
                                                @foreach ($metodos as $metodo)
                                                    <option value="{{$metodo->id}}">{{$metodo->nombre}}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error for="metodo_cambio_id" />
                                        </div>

                                        <div class="w-1/2">
                                        
                                                <input wire:model="monto_vuelto" type="number" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Monto">
                                        
                                            <x-input-error for="monto_vuelto" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div :class="{'hidden': (tipo_pago != 'credito')}" class="flex w-full ml-4">
                                    <p class="text-gray-500 font-semibold mr-3">Pago inicial</p>
                                    <div class="w-1/2">
                                        <input wire:model="pago_cliente" type="number" title="Pago inicial" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Pago inicial">
                                        <x-input-error for="pago_cliente" />
                                    </div>
                            </div>

                        </div>
                            
                    </div>

                    <div>
                    <hr>
                    <p class="text-gray-500 text-lg font-semibold mt-2 mb-3 ml-2">
                            Detalles de facturación:
                    </p>
                        <div class="mt-2">
                            <div>
                                <div class="text-gray-600 px-4">
                                    <p class="flex font-bold justify-between items-center mt-2">
                                    Cliente:
                                    <span class="font-bold">{{$cliente_select}}</span>
                                        <x-input-error for="cliente_select" />
                                    </p>
                                </div>                                    
                                <div class="text-gray-700 px-4">
                                    <p class="flex justify-between items-center">
                                        Subtotal
                                        <span class="font-semibold">{{ $moneda_simbolo }} {{round($subtotal / $tasa_dia,2)}}</span>
                                    </p>
                                    <p class="flex justify-between items-center">
                                        Descuento
                                        <span class="font-semibold">{{ $moneda_simbolo }} {{ round($descuento_total / $tasa_dia,2)}}</span>
                                    </p>
                                    <p class="flex justify-between items-center">
                                        Subtotal menos descuento
                                        <span class="font-semibold">{{ $moneda_simbolo }} {{round(($subtotal - $descuento_total) / $tasa_dia,2)}}</span>
                                    </p>
                                    <p class="flex justify-between items-center">
                                        IVA {{$iva_empresa}} %
                                        <span class="font-semibold">
                                        {{ $moneda_simbolo }} {{round(($this->iva / $tasa_dia),2)}}
                                        </span>
                                    </p>
                                    

                                    <div class="hidden" :class="{'hidden': tipo_pago != 2}">
                                        <hr class="mt-4 mb-3">
                                        <p class="flex justify-between items-center">
                                            Total pagado por el cliente (Crédito)
                                            <span class="font-semibold">
                                                {{ $moneda_simbolo }} {{round(($pago_cliente / $tasa_dia),2)}}
                                            </span>
                                        </p>
                                        <p class="flex justify-between items-center">
                                            Pendiente por pagar (Crédito)
                                            <span class="font-semibold">
                                                {{ $moneda_simbolo }} {{round(($total_venta - $pago_cliente) / $tasa_dia,2)}}
                                            </span>
                                        </p>
                                    </div>

                                  
                                    <hr>

                                    <div class="m-0 p-0">
                                        <p class="flex justify-between items-center mb-0 text-gray-400">
                                                Total recibido
                                                <span class="font-semibold">
                                                Bs {{round(($mostrar_total_pagado_bs),2)}} - $ {{round(($mostrar_total_pagado_dl),2)}} 
                                                </span>
                                        </p>


                                        
                                        <p class="flex justify-between items-center mb-0  text-gray-400">
                                                Cambio a cliente
                                                <span class="font-semibold">
                                                Bs {{round(($mostrar_total_cambio_bs),2)}} - $ {{round(($mostrar_total_cambio_dl),2)}} 
                                                </span>
                                        </p>




                                        <p class="flex justify-between items-center  text-gray-400">
                                                Por pagar
                                                <span class="font-semibold">
                                                Bs {{round(($pendiente_pagar_cliente_bs),2)}} - $ {{round(($pendiente_pagar_cliente_dl),2)}} 
                                                </span>
                                        </p>

                                    </div>

                                   
                                        
                                    

                                    <hr class="mt-4 mb-3">
                                    <div>
                                    <div class="flex justify-between items-center ">
                                        <p class="text-3xl font-bold">Total a pagar</p>

                                        <p class="text-3xl font-bold">{{ $moneda_simbolo }} {{round(($total_venta / $tasa_dia),2)}}</p> 
                
                                    </div>
                                    <div class="flex justify-end">
                                        <p class="text-2xl font-semibold">
                                           $ {{round(($total_venta / $tasa_dolar),2)}}
                                        </p>

                                    </div>
                                        
                                        
                                    </div>
                                        
                                </div>

                                <hr>

                                <div class="mt-6 ml-2">

                                    <div class="flex w-full h-full ml-2">
                                        <input type="checkbox" class=" ml-1" wire:model="imprimir" value="1">
                                        <p class="text-sm font-semibold text-gray-500 ml-2 mt-3">Imprimir comprobante</p>
                                    </div>
                                
                                    <div class="flex justify-start mt-2">
                                        <div class="ml-2 mr-2" :class="{'hidden': (imprimir != 1)}">
                                            <select id="tipo_comprobante" wire:model="tipo_comprobante" title="Tipo de comprobante" class="block bg-gray-100 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="tipo_comprobante">
                                                <option value="" selected>Comprobante</option>
                                                <option value="1">Factura</option>
                                                <option value="2">Nota de entrega</option>
                                            </select>
                                            <x-input-error for="tipo_comprobante" />
                                        </div>
                                    </div>
                                    <x-button
                                        wire:loading.attr="disabled"
                                        wire:target="save"
                                        class="mt-6 mb-4 mr-2"
                                        wire:click="save">
                                        <i class="fas fa-save mr-1"></i>
                                        Guardar venta
                                    </x-button>
                                </div>
                            </div>
                        </div>
                    </div>

                </aside>
            </div>
        @else
     
        @endif
    </section>
</div>

