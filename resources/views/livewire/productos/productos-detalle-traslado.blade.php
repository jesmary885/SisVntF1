<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
    <aside class="md:col-span-1 lg:col-span-2">
        <div class="card">
            <h5 class="modal-title ml-4 mt-2 text-md text-gray-800"> <i class="fas fa-boxes"></i> Disponibles en almacen
            </h5>
            
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class=flex>
                            <div class="w-1/4">

                                <select wire:model="buscador" id="buscador" class="form-control text-m" name="buscador">
                                    <option value="0">Modelo</option>
                                    <option value="1">Marca</option>
                                    <option value="2">Categoria</option>
                                    <option value="3">Código de barra</option>
                              
                                </select>

                                <x-input-error for="buscador" />

                            </div>
                            <input wire:model="search" placeholder="Ingrese {{ $item_buscar }}"
                                class="form-control mb-2">

                        </div>
                    </div>
                    <div class="ml-2">
                        <button title="Ayuda a usuario" class="btn btn-success btn-sm" wire:click="ayuda"><i
                                class="fas fa-info"></i>
                            Guía rápida
                        </button>
                    </div>

                </div>

                @if ($productos->count())

                    <table class="table table-bordered table-responsive-lg table-responsive-md table-responsive-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th>Cantidad</th>
                                <th>Prod/Cat</th>
                                <th>Marc/Mod</th>
                             
                                <th colspan="1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $producto)
                                <tr>
                                    <td>{{$producto->sucursals->find($sucursal)->pivot->cantidad}}</td>
                                    <td>{{ $producto->nombre }}/{{ $producto->categoria->nombre }}
                                    </td>
                                    <td>{{ $producto->marca->nombre }}/{{ $producto->modelo->nombre }}
                                    </td>
                                    <td width="10px">
                                 
                                             @livewire('productos.productos-traslado-seleccion', ['producto' => $producto,'sucursal' => $sucursal],key($producto->id))
                                    
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
            <div class="card-footer">
         
                    {{ $productos->links() }}

          

            </div>

            
        @else
            <div class="card-body">
                <strong>No hay registros</strong> <br>
            </div>
            @endif
        </div>
    </aside>

    <div class="card md:col-span-1 lg:col-span-2">


        @livewire('productos.productos-traslado-pendientes', ['sucursal' => $sucursal])
      

    </div>
</div>
