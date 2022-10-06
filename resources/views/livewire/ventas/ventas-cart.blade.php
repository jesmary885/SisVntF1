<div x-data="{ publico_general: @entangle('publico_general'),tipo_pago: @entangle('tipo_pago'),metodo_pago: @entangle('metodo_pago'),siguiente_venta: @entangle('siguiente_venta'), imprimir: @entangle('imprimir'),tipo_comprobante: @entangle('tipo_comprobante'),carrito: @entangle('carrito'), cant_metodos: @entangle('cant_metodos)}">
    <section class="text-gray-700">
        <h2 class=" modal-title font-bold text-md text-gray-800 text-center bg-gray-300"> Productos incluidos en venta</h2>
        @if (Cart::count())
        <div class="w-full overflow-auto h-48 bg-white">
            <table class="table table-bordered table-responsive-sm">
                <thead class="sticky left-0 top-0 thead-dark">
                    <tr>
                        <th class="text-center ">Cant</th>
                        <th class="text-center">Prod</th>
                        <th class="text-center">Subt</th>
                        <th colspan="1"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (Cart::content() as $item)
                        <tr class="overflow-hidden">
                            <td class="text-center text-sm bg-white">
                                <span> {{ $item->qty }}</span>
                            </td>
                            
                            <td class="flex text-center text-sm bg-white">
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
        <h2 class="modal-title font-bold text-md text-gray-800 text-center bg-gray-300"> Detalles del comprobante de venta</h2>

        <div class="grid md:grid-cols-1 lg:grid-cols-2 gap-4">
        
        
        <aside class="md:col-span-1 ">
            
            

            <div>
            <div class="w-full">
                <div class="flex justify-between w-full h-full mt-2">
                    <div class=" w-full ml-2">
                        <select id="tipo_pago" wire:model="tipo_pago" title="Tipo de pago" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="tipo_pago">
                            <option value="Contado"selected>Contado</option>
                            <option value="Credito">Crédito</option>
                        </select>
                        <x-input-error for="tipo_pago" />
                    </div>
                    <div class="ml-2 w-full">
                        <select id="cant_metodos" wire:model="cant_metodos" title="Cantidad de métodos de pago" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="cant_metodos">
                            <option value="" selected>Cantidad de métodos de pago</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <x-input-error for="cant_metodos" />
                    </div>
                </div>
                <div class="flex justify-between w-full h-full mt-2">
                    <div class="ml-2 mr-2 w-full">
                        <select id="estado_entrega" wire:model="estado_entrega" title="Estado de la entrega" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="tipo_garantia">
                            <option value="Entregado" selected>Entregado</option>
                            <option value="Por entregar">Por entregar</option>
                        </select>
                        <x-input-error for="estado_entrega" />
                    </div>
                    <div class="w-full">
                        <div class="w-full">
                            <input wire:model="descuento" type="number" min="0" title="Descuento en venta" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Descuento en venta %">
                            <x-input-error for="descuento" />
                        </div>
                    </div>
                </div>
                {{--metodos de pago--}}
                {{--con 1 metodo--}}
                <div class="flex justify-between w-full h-full mt-2">
                    <div class="w-full mr-2">
                            <select wire:model.lazy="metodo_id_1" class="block w-full bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="" selected>Seleccione el método pago</option>
                                @foreach ($metodos as $metodo)
                                    <option value="{{$metodo->id}}">{{$metodo->nombre}}</option>
                                @endforeach
                            </select>
                            <x-input-error for="metodo_id_1" />
                    </div>

                    <div class="w-full">
                        <input wire:model="monto1" type="number" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Monto recibido">
                        <x-input-error for="monto1" />
                    </div>
                </div>

                {{--con 2 metodos--}}
                <div :class="{'hidden': (cant_metodos == 1)}" class="flex justify-between w-full h-full mt-2">
                    <div class="w-full mr-2">
                            <select wire:model.lazy="metodo_id_2" class="block w-full bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="" selected>Seleccione el método pago</option>
                                @foreach ($metodos as $metodo)
                                    <option value="{{$metodo->id}}">{{$metodo->nombre}}</option>
                                @endforeach
                            </select>
                            <x-input-error for="metodo_id_2" />
                    </div>

                    <div class="w-full">
                        <input wire:model="monto2" type="number" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Monto recibido">
                        <x-input-error for="monto2" />
                    </div>
                </div>
                {{--con 3 metodos--}}
                <div :class="{'hidden': (cant_metodos == 1)}" class="flex justify-between w-full h-full mt-2">
                    <div :class="{'hidden': (cant_metodos == 2)}">
                        <div class="w-full mr-2">
                                <select wire:model.lazy="metodo_id_3" class="block w-full bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="" selected>Seleccione el método pago</option>
                                    @foreach ($metodos as $metodo)
                                        <option value="{{$metodo->id}}">{{$metodo->nombre}}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="metodo_id_3" />
                        </div>
                        <div class="w-full">
                            <input wire:model="monto3" type="number" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Monto recibido">
                            <x-input-error for="monto3" />
                        </div>
                    </div>
                </div>
                {{--con 4 metodos--}}
                <div :class="{'hidden': (cant_metodos == 1)}" class="flex justify-between w-full h-full mt-2">
                    <div :class="{'hidden': (cant_metodos == 2)}">
                        <div :class="{'hidden': (cant_metodos == 3)}">
                            <div class="w-full mr-2">
                                <select wire:model.lazy="metodo_id_4" class="block w-full bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="" selected>Seleccione el método pago</option>
                                    @foreach ($metodos as $metodo)
                                        <option value="{{$metodo->id}}">{{$metodo->nombre}}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="metodo_id_4" />
                            </div>
                            <div class="w-full">
                                <input wire:model="monto4" type="number" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Monto recibido">
                                <x-input-error for="monto4" />
                            </div>
                        </div>
                    </div>
                </div>
                {{--con 5 metodos--}}
                <div :class="{'hidden': (cant_metodos == 1)}" class="flex justify-between w-full h-full mt-2">
                    <div :class="{'hidden': (cant_metodos == 2)}">
                        <div :class="{'hidden': (cant_metodos == 3)}">
                            <div :class="{'hidden': (cant_metodos == 4)}">
                                <div class="w-full mr-2">
                                    <select wire:model.lazy="metodo_id_5" class="block w-full bg-gray-50 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <option value="" selected>Seleccione el método pago</option>
                                        @foreach ($metodos as $metodo)
                                            <option value="{{$metodo->id}}">{{$metodo->nombre}}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="metodo_id_5" />
                                </div>
                                <div class="w-full">
                                    <input wire:model="monto5" type="number" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Monto recibido">
                                    <x-input-error for="monto5" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- fin de metodo de pagos --}}

                <div :class="{'hidden': (tipo_pago != 'Credito')}">
                    <div class="mt-2 ml-2">
                        <input wire:model="pago_cliente" type="number" title="Pago inicial" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Pago inicial">
                        <x-input-error for="pago_cliente" />
                    </div>
                </div>

                <div class="flex justify-between w-full" :class="{'hidden': metodo_pago != 'Efectivo'}">
                    <div class="mt-2 mr-1 ml-2 w-full">
                        <input wire:model="cash_received" type="number" title="Efectivo recibido" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Efectivo recibido">
                        <x-input-error for="cash_received" />
                    </div>
                    <div class="mr-2 ml-2 py-1 mt-2 w-full">
                        <span class="text-green-700 font-bold"><i class="far fa-money-bill-alt"></i> Cambio {{ $cambio}}</span>
                    </div>
                </div>
                <div :class="{'hidden': metodo_pago != 'Efectivo y otro metodo'}">
                    <hr class="p-0 mt-2 mb-1">
                    <p class="text-gray-700 text-center text-sm font-semibold mb-1 mt-0 p-0">Dinero recibido</p>
                    <div class="flex justify-between w-full" >
                        <div class=" ml-2 w-full">
                            <input wire:model="cash_received" type="number" title="Efectivo recibido" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Efectivo">
                            <x-input-error for="cash_received" />
                        </div>
                        <div  class="ml-2 w-full">
                            <input wire:model="other_method" type="number" title="Recibido otro metodo" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Otro método">
                            <x-input-error for="other_method" />
                        </div>
                    </div>
                    <div class="mr-2 ml-3 py-1 mt-2 w-full">
                        <span class="text-green-700 font-bold"><i class="far fa-money-bill-alt ml-"></i> Cambio {{ $cambio}}</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-between ml-2">
                <div class="flex w-full h-full ml-2">
                <input type="checkbox" class=" ml-1" wire:model="publico_general" value="1">
                <p class="text-sm font-semibold text-gray-500 ml-2 mt-3">Público general</p>
                </div>
            </div>

            <div :class="{'hidden': (publico_general == '1')}">
                <div class="flex items-center justify-between m-0 bg-gray-300">
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
                            <thead class="thead-dark">
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

        </aside>

        <div class="md:col-span-1 ">
        <div class="mt-2">
                    <div>
                        <div class="text-gray-600 px-4">
                            <p class="flex font-bold justify-between items-center mt-2">
                                Cliente:
                                <span class="font-bold">{{$cliente_select}}</span>
                                <x-input-error for="cliente_select" />
                            </p>
                        </div>
                        <hr>
                        <div class="text-gray-700 px-4">
                            <p class="flex justify-between items-center">
                                Subtotal
                                <span class="font-semibold">{{ $moneda_simbolo }} {{round($subtotal / $tasa_dia,2)}}</span>
                            </p>
                            <p class="flex justify-between items-center">
                            Descuento
                            {{-- @if ($canjeo == false)
                                <span class="font-semibold">{{ $moneda_simbolo }} {{(Cart::subtotal() * ($this->descuento / 100)) * $tasa_dia}}</span>
                            @else --}}
                                <span class="font-semibold">{{ $moneda_simbolo }} {{ round($descuento_total / $tasa_dia,2)}}</span>
                            {{-- @endif --}}
                            {{-- <span class="font-semibold">{{ $moneda_simbolo }} {{$descuento_total = Cart::subtotal() * ($this->descuento / 100)}}</span> --}}
                            </p>
                            <p class="flex justify-between items-center">
                            Subtotal menos descuento
                            {{-- @if ($canjeo == false)
                            <span class="font-semibold">{{ $moneda_simbolo }} {{(Cart::subtotal() - (Cart::subtotal() * ($this->descuento / 100))) * $tasa_dia}}</span>
                            @else --}}
                            <span class="font-semibold">{{ $moneda_simbolo }} {{round(($subtotal - $descuento_total) / $tasa_dia,2)}}</span>
                            {{-- @endif --}}
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
                                    Total pagado por el cliente
                                    <span class="font-semibold">
                                    {{ $moneda_simbolo }} {{round(($pago_cliente / $tasa_dia),2)}}
                                    </span>
                                </p>
                                <p class="flex justify-between items-center">
                                    Pendiente por pagar
                                    <span class="font-semibold">
                                    {{-- @if ($canjeo == false)
                                        {{ $moneda_simbolo }} {{(Cart::subtotal() - (Cart::subtotal() * ($this->descuento / 100))) - ($pago_cliente)}}
                                    @else --}}
                                    {{ $moneda_simbolo }} {{round(($total_venta - $pago_cliente) / $tasa_dia,2)}}
                                    {{-- @endif --}}
                                </span>
                                </p>
                            </div>

                            <hr class="mt-4 mb-3">
                            <p class="flex justify-between items-center font-semibold">
                            <span class="text-lg">Total a pagar</span>
                            {{-- @if ($canjeo == false) --}}
                            {{-- S/ {{Cart::subtotal() - (Cart::subtotal() * ($this->descuento / 100))}} --}}
                            {{ $moneda_simbolo }} {{round(($total_venta / $tasa_dia),2)}}
                            {{-- @else --}}
                            {{-- S/ {{Cart::subtotal() - ($this->descuento_total)}} --}}
                            {{-- S/ {{Cart::subtotal() - ($this->descuento_total)}}
                            @endif --}}
                            </p>
                        </div>

                    <hr>

                    <div class="mt-6 ml-2">
                        <div class="flex w-full h-full mt-1 ml-2">
                            <input type="checkbox" class="ml-1" wire:model="send_mail" value="1">
                            <p class="text-sm font-semibold text-gray-500 ml-2 mt-3">Enviar comprobante a correo</p>
                        </div>

                        <div class="flex w-full h-full ml-2">
                            <input type="checkbox" class=" ml-1" wire:model="imprimir" value="1">
                            <p class="text-sm font-semibold text-gray-500 ml-2 mt-3">Imprimir comprobante</p>
                        </div>
                    
                        <div class="flex justify-start mt-2">
                            <div class="ml-2 mr-2" :class="{'hidden': (imprimir != 1)}">
                                <select id="tipo_comprobante" wire:model="tipo_comprobante" title="Tipo de comprobante" class="block bg-gray-100 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="tipo_comprobante">
                                    <option value="" selected>Comprobante</option>
                                    <option value="1">Factura</option>
                                    <option value="2">Ticket</option>
                                    <option value="3">Nota de entrega</option>
                                </select>
                                <x-input-error for="tipo_comprobante" />
                            </div>
                            {{--<div :class="{'hidden': tipo_comprobante != 2 }">
                                    <div :class="{'hidden': (imprimir != 1)}">
                                        <select wire:model="impresora_id" class="block bg-gray-100 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                            <option value="" selected>Seleccione la impresora</option>
                                            @foreach ($impresoras as $impresora)
                                                <option value="{{$impresora->id}}">{{$impresora->nombre}}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error for="impresora_id" />
                                    </div>
                            </div> --}}
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
        </div>
        @else
        <hr class="m-0 p-0">
            <p class="text-md justify-center text-gray-700 m-4">No ha seleecionado ningún producto</p>
        @endif
    </section>
</div>

