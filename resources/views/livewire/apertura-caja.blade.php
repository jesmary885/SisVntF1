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
                       <input wire:model="sucursal_select" type="text" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
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
                        <input wire:model="monto_bolivares" type="number" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Cantidad en dólares">
                        <x-input-error for="monto_bolivares" />
                    </div>
                    <div class="mr-2">
                        <input wire:model="monto_dolares" type="number" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Cantidad en bolivares">
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

                            <div class="overflow-x-auto relative shadow-md sm:rounded-lg ">
                                <table class="w-full text-sm text-left text-gray-400">
                                    <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                                    <tr>
                                        <th scope="col" class="py-3 px-6 text-gray-300 text-sm text-center">Caja</th>
                                        <th scope="col" class="py-3 px-6 text-gray-300 text-sm text-center">Sucursal</th>
                                        <th scope="col" class="py-3 px-6 text-gray-300 text-sm text-center">Cantidad en bolivares</th>
                                        <th scope="col" class="py-3 px-6 text-gray-300 text-sm text-center">Cantidad en dólares</th>
                                        <th scope="col" class="py-3 px-6 text-gray-300 text-sm text-center">Observación de apertura</th>    
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-gray-800 border-gray-700 hover:bg-gray-600">
                                        <th scope="row" class="py-4 px-6 font-medium whitespace-nowrap">{{$movimiento->caja->nombre}}</td>
                                        <td class="py-4 px-6 text-center">{{$movimiento->caja->sucursal->nombre}}</td>
                                        <td class="py-4 px-6 text-center">{{$movimiento->caja->saldo_bolivares}}</td>
                                        <td class="py-4 px-6 text-center">{{$movimiento->caja->saldo_dolares}}</td>
                                        <td class="py-4 px-6 text-center">{{$movimiento->observacion}}</td>
                                        <td class="py-4 px-6 text-center" width="10px">
                                            @livewire('cierre-caja', ['movimiento' => $movimiento],key($movimiento->id))
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class=" mt-8 ">
                            <div class=" justify-center ">
                                <h2 class="font-bold text-gray-700 text-center text-lg">Datos de cierre</h2>
                            </div>
                            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            @if ($array)
                                <table class="w-full text-sm text-left text-gray-400">
                                    <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                                        <tr>
                                            <th scope="col" class="py-3 px-6 text-gray-300 text-sm text-center">
                                            Tipo de movimiento
                                            </th>
                                            <th scope="col" class="py-3 px-6 text-gray-300 text-sm text-center">
                                            Método de pago
                                            </th>
                                            <th scope="col" class="py-3 px-6 text-gray-300 text-sm text-center">
                                            Monto
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($array as $value)
                                            <tr class="bg-gray-800 border-gray-700 hover:bg-gray-600">
                                                <th scope="row" class="py-2 px-2 font-medium whitespace-nowrap text-white text-center">
                                                    Ingreso
                                                </th>
                                                <td class="py-2 px-2 text-center">
                                                    {{$value['metodo_nombre']}}
                                                </td>
                                                <td class="py-2 px-2 text-center">
                                                    {{$value['quantity']}}
                                                </td>
                                            </tr>
                                        @endforeach   
                                    </tbody>
                                </table>
                                @else
                                    <div class="card-body">
                                        <strong>No hay registros</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
