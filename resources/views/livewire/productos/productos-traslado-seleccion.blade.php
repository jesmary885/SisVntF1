<div x-data="{ change_price: @entangle('change_price') , precios: @entangle('precios')}">
    <button type="submit" class="btn btn-primary btn-sm" wire:click="open">
        <i class="fas fa-check"></i>
   </button> 

   @if($isopen)
        <div x-data>
            <div class="modal d-block" tabindex="-1" role="dialog" style="overflow-y: auto; display: block;" wire:click.self="$set('isopen', false)">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title py-0 text-lg text-gray-800"> <i class="	fas fa-shopping-basket"></i>  Traslado de equipos</h5>
                        </div>
                        <div class="modal-body">
                            <h2 class="text-sm ml-2 mb-4 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Seleccione cantidad y la sucursal destino, luego haga click en "Enviar"</h2> 
                                <div class="flex justify-between">
                                    <div class="mr-4 flex justify-between">
                                        <x-secondary-button class="ml-2"
                                            disabled
                                            x-bind:disabled="$wire.qty <= 1"
                                            wire:loading.attr="disabled"
                                            wire:target="decrement"
                                            wire:click="decrement">
                                            -
                                        </x-secondary-button>

                                        <input wire:model="qty" type="number" min="1" max="{{$quantity}}" class="inputNumber text-center appearance-none block text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="{{$qty}}">
                            
                                        {{-- <span class="mx-2 text-gray-700">{{$qty}}</span> --}}
                            
                                        <x-secondary-button class="mr-4"
                                            x-bind:disabled="$wire.qty >= $wire.quantity"
                                            wire:loading.attr="disabled"
                                            wire:target="increment"
                                            wire:click="increment">
                                            +
                                        </x-secondary-button>
                                    </div>

                                    <div>
                                        <div class="w-1/2">
                                            <select wire:model="sucursal_id"
                                                class="block bg-gray-100 border border-gray-200 text-gray-400 py-1 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                                <option value="" selected>Sucursal destino</option>
                                                @foreach ($sucursales as $sucursale)
                                                    <option value="{{ $sucursale->id }}">{{ $sucursale->nombre }}</option>
                                                @endforeach
                                            </select>
                                            
                                        </div>
                                        <x-input-error class="w-full" for="sucursal_id" />
                                    </div>
                                </div>
                        </div>

                        <div class="modal-footer flex">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" wire:click="close" >Cerrar</button>
                            <x-button
                                x-bind:disabled="$wire.qty > $wire.quantity || $wire.qty < 1 || $wire.quantity < 1"
                                wire:click="addItem"
                                wire:loading.attr="disabled"
                                wire:loading.attr="disabled"
                                wire:target="addItem">
                               
                                Enviar
                            </x-button>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
   @endif
</div>