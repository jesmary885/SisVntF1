<div x-data="{ tipo_pago: @entangle('tipo_pago'),metodo_pago: @entangle('metodo_pago'),siguiente_venta: @entangle('siguiente_venta'), imprimir: @entangle('imprimir'),send_email: @entangle('send_email'),tipo_comprobante: @entangle('tipo_comprobante'),carrito: @entangle('carrito')}">
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
                        <th class="text-center">Pts</th>
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
                                <h3 class="mr-4 text-md text-gray-600">{{$item->name}} {{$item->options['modelo']}}</h3>
                                @if ($puntos_canjeo >  $item->options['puntos'])
                                            <a class="font-bold text-xl" href="#"
                                            wire:loading.attr="disabled"
                                            wire:target="canjear"
                                            wire:click="canjear('{{$item->id}}}')">
                                            <i class="fas fa-award"></i>
                                            </a>  
                                     @endif
                            </td>
                            <td class="text-center text-sm bg-white">
                                <span>S/ {{ $item->price }}</span>
                            </td>
                            <td class="text-center text-sm bg-white">
                                <span>{{ $item->options['puntos'] }}</span>
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
        <h2 class=" modal-title font-bold text-md text-gray-800 text-center bg-gray-300"> Ciente</h2>
            <div class="bg-white rounded-lg shadow pb-1">
                <div class="flex items-center justify-between m-0 bg-gray-300">
                    <div class="flex-1">
                        <input wire:model="search" placeholder="*Seleccione el cliente o escriba aquí su nombre, apellido o nro documento a buscar" class="form-control">
                    </div>
                   
                    <div class="ml-1">
                        @livewire('admin.clientes.clientes-create',['vista' => "ventas",'accion' => 'create'])
                    </div>
                </div>
                @if ($clientes->count())
                    <div class="bg-white">
                        <table class="table table-striped table-responsive-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Documento</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Puntos</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientes as $cliente)
                                    <tr>
                                        <td class="text-center">{{$cliente->nombre}} {{$cliente->apellido}}</td>
                                        <td class="text-center">{{$cliente->nro_documento}}</td>
                                        <td class="text-center">{{$cliente->email}}</td>
                                        <td class="text-center">{{$cliente->puntos}}</td>
                                        <td width="10px">
                                        <button
                                            class="ml-4 btn btn-primary btn-sm" title="Seleccionar cliente"
                                            wire:click="select_u('{{$cliente->id}}}')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="ml-1">
                        {{$clientes->links()}}
                    </div>
                @else
                    <div>
                        <strong>No hay registros</strong>
                    </div>
                @endif
            
            
            </div>
        <h2 class="modal-title font-bold text-md text-gray-800 text-center bg-gray-300"> Detalles del comprobante de venta</h2>
        
        <div class="grid md:grid-cols-1 lg:grid-cols-2 gap-4">
            <aside class="md:col-span-1 ">
                <div class="bg-white rounded-lg shadow w-full">
                    <div class="flex justify-between w-full h-full mt-2">
                        <div class=" w-full ml-2">
                      
                            <select id="tipo_pago" wire:model="tipo_pago" title="Tipo de pago" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="tipo_pago">
                                <option value="" selected>*Tipo de pago</option>
                                <option value="1">Contado</option>
                                <option value="2">Crédito</option>
                            </select>
                            <x-input-error for="tipo_pago" />
                        </div>
                        <div class="ml-2 mr-2 w-full">
                            <select id="metodo_pago" wire:model="metodo_pago" title="Método de pago" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="tipo_garantia">
                                <option value="" selected>*Método de pago</option>
                                <option value="1">Efectivo</option>
                                <option value="2">Tarjeta Credito</option>
                                <option value="3">Tarjeta Debito </option>
                                <option value="4">Efectivo y Tarjeta Debito</option>
                                <option value="5">Efectivo y Tarjeta Credito</option>
                            </select>
                            <x-input-error for="metodo_pago" />
                        </div>
                        
                    </div>
            
                    <div class="flex justify-between w-full h-full mt-2">
                        <div class="ml-2 mr-2 w-full">
                            <select id="estado_entrega" wire:model="estado_entrega" title="Estado de la entrega" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="tipo_garantia">
                                <option value="" selected>*Estado de entrega</option>
                                <option value="1">Entregado</option>
                                <option value="2">Por entregar</option>
                            </select>
                            <x-input-error for="estado_entrega" />
                        </div>
                        <div class="mr-2 w-full">
                            <div class="w-full mr-2">
                                <input wire:model="descuento" type="number" min="0" title="Descuento en venta" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Descuento en venta %">
                                <x-input-error for="descuento" />
                            </div>
                        </div>
                    </div>
            
            
                    <div :class="{'hidden': (tipo_pago != 2)}">
                            <div class=" mr-2 mt-2 ml-2">
                                <input wire:model="pago_cliente" type="number" title="Pago inicial" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="*Pago inicial">
                                <x-input-error for="pago_cliente" />
                            </div>
                    </div>

                    <div class="flex justify-between w-full" :class="{'hidden': (metodo_pago != 1)}">
                        <div class="mt-2 mr-1 ml-2 w-full">
                            <input wire:model="cash_received" type="number" title="Efectivo recibido" min="0" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Efectivo recibido">
                            <x-input-error for="cash_received" />
                        </div>
                     
                        <div class="mr-2 ml-2 py-1 mt-2 w-full">
                            <span class="text-green-700 font-bold"><i class="far fa-money-bill-alt"></i> Cambio {{ $cambio}}</span>
                        </div>

                </div>

                   
            
                    <hr>
                    
                    <div class="flex w-full h-full mt-1 ml-4">
                        <input type="checkbox" class="ml-1 mt-1" wire:model="send_mail" value="1">
                        <p class="text-sm font-semibold text-gray-500 ml-2">Enviar comprobante al correo del cliente</p>
                    </div>
            
                    <div class="flex w-full h-full mt-1 ml-4">
                        <input type="checkbox" class=" ml-1 mt-1" wire:model="imprimir" value="1">
                        <p class="text-sm font-semibold text-gray-500 ml-2">Imprimir comprobante</p>
                    </div>
            
                    <div class="flex justify-start mt-2">
                        <div class="ml-2 mr-2" :class="{'hidden': (imprimir != 1)}">
                                <select id="tipo_comprobante" wire:model="tipo_comprobante" title="Tipo de comprobante" class="block bg-gray-100 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="tipo_comprobante">
                                    <option value="" selected>*Comprobante</option>
                                    <option value="1">Factura</option>
                                    <option value="2">Ticket</option>
                                </select>
                                <x-input-error for="tipo_comprobante" />
                        </div>
                        {{-- <div :class="{'hidden': tipo_comprobante != 2 }">
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
            
                    <h2 class="text-sm mt-4 ml-4 text-red-600 font-semibold"> * Campos obligatorios</h2>
        
                    <div class="flex mt-6 ml-4">
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
            </aside>



            <div class="md:col-span-1" :class="{'hidden': carrito == ''}">
                <div class="bg-white rounded-lg shadow mb-4 h-96">
                    <div class="px-4">
                        <div class="text-gray-600">
                        
                            <p class="flex font-bold justify-between items-center mt-2">
                                Cliente: 
                                <span class="font-bold">{{$cliente_select}}</span>
                                <x-input-error for="cliente_select" />
                            </p>
            
                        </div>
                        <hr class="mt-2 mb-2">
        
                    <div class="text-gray-700">
                        <p class="flex justify-between items-center">
                            Total parcial
                            <span class="font-semibold">S/ {{$subtotal}}</span>
                        </p>
                        <p class="flex justify-between items-center">
                            Descuento
                            {{-- @if ($canjeo == false)
                                <span class="font-semibold">S/ {{Cart::subtotal() * ($this->descuento / 100)}}</span>
                            @else --}}
                                <span class="font-semibold">S/ {{$descuento_total}}</span>
                            {{-- @endif --}}
                           
        
                            {{-- <span class="font-semibold">S/ {{$descuento_total = Cart::subtotal() * ($this->descuento / 100)}}</span> --}}
                        </p>
                      
                        <p class="flex justify-between items-center">
                            Subtotal menos descuento
                            {{-- @if ($canjeo == false)
                            <span class="font-semibold">S/ {{Cart::subtotal() - (Cart::subtotal() * ($this->descuento / 100))}}</span>
                            @else --}}
                            <span class="font-semibold">S/ {{$subtotal - $descuento_total}}</span>
                        {{-- @endif --}}
                        </p>
                        {{-- <p class="flex justify-between items-center">
                            IVA {{$iva*100}} %
                            <span class="font-semibold">
                            S/ {{Cart::subtotal() * $this->iva}}
                            </span>
                        </p> --}}
        
        
                        <div class="hidden" :class="{'hidden': tipo_pago != 2}">
                            <hr class="mt-4 mb-3">
                            <p class="flex justify-between items-center">
                                Total pagado por el cliente
                                <span class="font-semibold">
                                S/ {{$pago_cliente}}
                                </span>
                            </p>
                            <p class="flex justify-between items-center">
                                Pendiente por pagar
                                <span class="font-semibold">
                                    {{-- @if ($canjeo == false)
                                    S/ {{(Cart::subtotal() - (Cart::subtotal() * ($this->descuento / 100))) - ($pago_cliente)}}
                                    @else --}}
                                S/ {{$total_venta - $pago_cliente}}
                                {{-- @endif --}}
                            </span>
                            </p>
                        </div>
                        
                        <hr class="mt-4 mb-3">
                        <p class="flex justify-between items-center font-semibold">
                            <span class="text-lg">Total a pagar</span>
                            {{-- @if ($canjeo == false) --}}
                            {{-- S/ {{Cart::subtotal() - (Cart::subtotal() * ($this->descuento / 100))}} --}}
                            S/ {{$total_venta}}
                            {{-- @else --}}
                            {{-- S/ {{Cart::subtotal() - ($this->descuento_total)}} --}}
                            {{-- S/ {{Cart::subtotal() - ($this->descuento_total)}}
                            @endif --}}
                        </p>
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

