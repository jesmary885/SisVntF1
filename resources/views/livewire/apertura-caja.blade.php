<div x-data="{ aperturo: @entangle('aperturo'), limitacion: @entangle('limitacion')}">
    <div class="card">
     
        <h1 class="py-0 text-lg text-gray-700 ml-4 mt-1 font-semibold"> Apertura y cierre de caja</h1>
    </div>
    <div class="card w-full pt-0 m-0">
        <div class="card-body w-full pt-0 mt-0">
            <div :class="{'hidden': (aperturo == 'si')}">
                <div class="flex">
                    <i class="fas fa-location-arrow mt-3 mr-1"></i>
                    <h2 class="text-lg inline mt-2">Sucursal y caja a aperturar</h2>
                </div>

                <div class="flex justify-between w-full mt-3 mr-2">
                    <div :class="{'hidden': (limitacion == 'si')}" class="w-full">
                        <select wire:model="sucursal_id" class="block mr-2 w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="" selected>Sucursal</option>
                                @foreach ($sucursales as $sucursal)
                            <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                            @endforeach
                        </select>
                        <x-input-error for="sucursal_id" />
                    </div>

                    <div :class="{'hidden': (limitacion == 'no')}" class="w-full mr-2">
                       <input title="Sucursal" wire:model="sucursal_select" type="text" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                       <x-input-error for="sucursal_select" />
                   </div>

                   <div class="w-full ml-2">
                        <select wire:model="caja_id" class="block mr-2 w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="" selected>Caja</option>
                                @foreach ($cajas as $caja)
                                <option value="{{$caja->id}}">{{$caja->nombre}}</option>
                            @endforeach
                        </select>
                        <x-input-error for=caja_id" />
                    </div>
                </div>

                <hr>

                <div class="flex">
                    <i class="fas fa-location-arrow mt-3 mr-1"></i>
                    <h2 class="text-lg inline mt-2">Monto y observaciones</h2>
                </div>

                <div class="flex w-1/2 mt-3 mr-2">
                    <div class="mr-2">
                        <input wire:model="monto_bolivares" type="number" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Cantidad en bolivares">
                        <x-input-error for="monto_bolivares" />
                    </div>
                    <div class="mr-2">
                        <input wire:model="monto_dolares" type="number" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Cantidad en dólares">
                        <x-input-error for="monto_dolares" />
                    </div>
                </div>

                <div class="mt-3 mr-2">
                        <textarea wire:model="observaciones" class="resize-none rounded-md outline-none w-full px-2 appearance-none block bg-gray-50 text-gray-700 border border-gray-200 py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="observaciones" cols="80" rows="2" required placeholder="Observaciones"></textarea>
                        <x-input-error for="observaciones" />
                    </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary" wire:click="aperturar">
                        <i class="fas fa-file-download"></i> Guardar
                    </button>
                </div>
            </div>

            <div :class="{'hidden': (aperturo == 'no')}">
                <div class="card-body">
                    @if($movimiento)
                        <div class=" justify-center ">
                            <h2 class="font-bold text-gray-700 text-center text-lg">Datos de apertura</h2>
                        </div>
                        <div class="m-2">
                            <div class="flex">
                                <strong class="text-gray-700 text-md mr-2 mb-0">Sucursal: </strong> <p class="text-gray-700 text-md">{{$movimiento[0]['caja']['sucursal']['nombre']}}</p>
                            </div>

                            <div class="flex">
                                <strong class="text-gray-700 text-md mr-2 mb-0">Caja: </strong> <p class="text-gray-700 text-md">{{$movimiento[0]['caja']['nombre']}}</p>
                            </div>

                            <div class="flex">
                                <strong class="text-gray-700 text-md mr-2">Fecha y hora de apertura: </strong> <p class="text-gray-700 text-md"> {{  \Carbon\Carbon::parse($movimiento[0]['created_at'])->format('d-m-Y h:i:s') }}</p>
                            </div>
                            
                            
                        </div>

                            <div class="overflow-x-auto relative shadow-md sm:rounded-lg ">
                                <table class="w-full text-left text-gray-400">
                                    <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                                    <tr>
                                        <th scope="col" class="py-3 px-6 text-gray-300 text-md text-center">Tipo de dato</th>
                                        <th scope="col" class="py-3 px-6 text-gray-300 text-md text-center">Cantidad en bolivares</th>
                                        <th scope="col" class="py-3 px-6 text-gray-300 text-md text-center">Cantidad en dólares</th>
                                        <th scope="col" class="py-3 px-6 text-gray-300 text-md text-center">Observación de apertura</th>    
                                    </tr>
                                </thead>
                                <tbody>
                                 <tr class="bg-gray-800 border-gray-700 hover:bg-gray-600">
                                        <td class="py-4 px-6 text-md text-center">Inicial</td>
                                        <td class="py-4 px-6 text-md text-center">{{$inicial_bolivares->cantidad}}</td>
                                        <td class="py-4 px-6 text-md text-center">{{$inicial_dolares->cantidad}}</td>
                                        <td class="py-4 px-6 text-md text-center">{{$movimiento[0]['observacion']}}</td>
                                    </tr>
                                    <tr class="bg-gray-800 border-gray-700 hover:bg-gray-600">
                                        <td class="py-4 px-6 text-md text-center">Acumulado</td>
                                        <td class="py-4 px-6 text-md text-center">{{$movimiento[0]['caja']['saldo_bolivares']}}</td>
                                        <td class="py-4 px-6 text-md text-center">{{$movimiento[0]['caja']['saldo_dolares']}}</td>
                                        <td class="py-4 px-6 text-md text-center">-</td>
                                    </tr> 

                      
                                </tbody>
                            </table>
                        </div>

                        <div class=" mt-8 ">
                            <div class=" justify-center ">
                                <h2 class="font-bold text-gray-700 text-center text-lg">Datos de cierre</h2>
                            </div>
                            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            @if ($array || $array_cambios || $array_compras)
                   
                                <table class="w-full text-sm text-left text-gray-400">
                                    <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                                        <tr>
                                            <th scope="col" class="py-3 px-6 text-gray-300 text-md text-center">
                                            Tipo de movimiento
                                            </th>
                                            <th scope="col" class="py-3 px-6 text-gray-300 text-md text-center">
                                            Método de pago
                                            </th>
                                            <th scope="col" class="py-3 px-6 text-gray-300 text-md text-center">
                                            Monto
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($array)
                                            @foreach ($array as $value)
                                                    <tr class="bg-gray-800 border-gray-700 hover:bg-gray-600">
                                                        <th scope="row" class="py-2 px-2 text-md font-medium whitespace-nowrap text-white text-center">
                                                            Ingreso
                                                        </th>
                                                        <td class="py-2 px-2 text-md text-center">
                                                            {{$value['metodo_nombre']}}
                                                        </td>
                                                        <td class="py-2 px-2 text-md text-center">
                                                            {{$value['quantity']}}
                                                        </td>
                                                    </tr>
                                            @endforeach 
                                        @endif  
                                        @if ($array_cambios)
                                            @foreach ($array_cambios as $value_cambios)
                                                    <tr class="bg-gray-800 border-gray-700 hover:bg-gray-600">
                                                        <th scope="row" class="py-2 px-2 text-md font-medium whitespace-nowrap text-white text-center">
                                                            Cambio a cliente
                                                        </th>
                                                        <td class="py-2 px-2 text-md text-center">
                                                            {{$value_cambios['metodo_nombre']}}
                                                        </td>
                                                        <td class="py-2 px-2 text-md text-center">
                                                            {{$value_cambios['quantity_vueltos']}}
                                                        </td>
                                                    </tr>
                                            @endforeach   
                                        @endif
                                        @if ($array_compras)
                                            @foreach ($array_compras as $value_compras)
                                                    <tr class="bg-gray-800 border-gray-700 hover:bg-gray-600">
                                                        <th scope="row" class="py-2 px-2 text-md font-medium whitespace-nowrap text-white text-center">
                                                            Egreso por compra
                                                        </th>
                                                        <td class="py-2 px-2 text-md text-center">
                                                            {{$value_compras['metodo_nombre']}}
                                                        </td>
                                                        <td class="py-2 px-2 text-md text-center">
                                                            {{$value_compras['quantity']}}
                                                        </td>
                                                    </tr>
                                            @endforeach   
                                        @endif
                                    </tbody>
                                </table>
                                @else
                                    <div class="text-center m-2">
                                        <p class="text-md text-gray-700">No se ha registrado ningún movimiento</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="text-center mt-4 flex">
                            <button type="submit" class="btn btn-primary" wire:click="export()">
                                <i class="fas fa-file-download"></i> Exportar
                            </button>
                          
                            <div class="ml-2">
                                @livewire('cierre-caja', ['movimiento' => $movimiento[0]],key($movimiento[0]['id']))
                            </div>
                            
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
