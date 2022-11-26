<div class="w-full" x-data="{ change_price: @entangle('change_price') , precios: @entangle('precios')}">
  
           
                                <div class="flex justify-between w-full">
                                    <div class="mr-2 flex justify-between">
                                        <x-secondary-button class="ml-2"
                                        disabled
                                        x-bind:disabled="$wire.qty <= 1"
                                        wire:loading.attr="disabled"
                                        wire:target="decrement"
                                        wire:click="decrement">
                                        -
                                        </x-secondary-button>
                                        <input wire:model="qty" autofocus type="number" min="1" max="{{$quantity}}" class="inputNumber text-center appearance-none block text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="{{$qty}}">
                                        <x-secondary-button class="mr-2" 
                                            x-bind:disabled="$wire.qty >= $wire.quantity"
                                            wire:loading.attr="disabled"
                                            wire:target="increment"
                                            wire:click="increment">
                                            +
                                        </x-secondary-button>
                                    </div>
                                    <div>
                                        <div class="w-1/2" :class="{'hidden': change_price == 'si'}">
                                            <select id="precios" wire:model="precios" class="block ml-1 bg-gray-100 border border-gray-200 text-gray-400 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="tipo_garantia">
                                                <option value="1" selected>Precio unitario</option>
                                                <option value="2">Precio al mayor</option>
                                            </select>
                                            <x-input-error for="precios" />
                                        </div>
        
                                        <div class="w-1/2" :class="{'hidden': change_price == 'no'}">
                                            <div>
                                                <select id="precios" wire:model="precios" class="block ml-1 bg-gray-100 border border-gray-200 text-gray-400 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="tipo_garantia">
                                                    {{-- <option value="" selected>Precio de venta</option> --}}
                                                   <option value="1" selected>Precio unitario</option>
                                                   <option value="2">Precio al mayor</option>
                                                   <option value="4">Precio por combo</option>
                                                   <option value="3">Precio manual</option>
                                               </select>
                                               <x-input-error for="precios" />
                                            </div>
                                
                                            
                                        </div>
                                        

                                    </div>
                                    <button id="button_addItem" type="submit" class="btn btn-primary btn-sm ml-2" 
                                        x-bind:disabled="$wire.qty > $wire.quantity"
                                        wire:click="addItem"
                                        wire:loading.attr="disabled"
                                        wire:loading.attr="disabled"
                                        wire:target="addItem">
                                        Agregar
                                    </button> 
                                </div>

                                <div class=" mt-2" :class="{'hidden': precios != '3'}">
                                    <div>
                                        <div>
                                            <input wire:model="precio_manual" type="number" min="0" class=" ml-48 w-1/3 w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Precio manual">
                                        </div>
                                        <div>
                                            <x-input-error class=" ml-48 w-1/3" for="precio_manual" />
                                        </div>
                                    </div>
                                </div>
                                
    <!-- <script>
        document.getElementById('button_addItem').focus()
    </script>       -->
 
</div>






