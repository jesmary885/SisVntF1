<div>
    <h5 class="modal-title ml-4 mt-2 text-md text-gray-800"> <i class="fas fa-dolly"></i>  Equipos pendientes por recibir </h5>
        <hr class="m-0 ">

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
                        <button
                            title="Ayuda a usuario"
                            class="btn btn-success btn-sm" 
                            wire:click="ayuda"><i class="fas fa-info"></i>
                            Guía rápida
                        </button>
                    </div>

                </div>
                @if ($trasl->count())
              
                <table class="table table-bordered table-responsive-lg table-responsive-md table-responsive-sm" >
                    <thead class="thead-dark">
                        <tr>
                            <th>Cantidad</th>
                            <th>Lote</th>
                            <th>Prod/Cat</th>
                            <th>Marc/Mod</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trasl as $p)
                            <tr>
                            <td>{{$p->cantidad}}</td>
                            <td>{{$p->lote}}</td>
                            <td>{{$p->producto->nombre}}/{{$p->producto->categoria->nombre}}</td>
                            <td>{{$p->producto->marca->nombre}}/{{$p->producto->modelo->nombre}}</td>

                            <td width="10px">
                                <button
                                class="btn btn-success btn-sm" 
                                wire:click="recibir('{{$p->id}}')"
                                title="Recibir todos los productos">
                                <i class="fas fa-check-double"></i>
                                </button>
                            </td>
                            <td width="10px">
                                 @livewire('productos.productos-recibir-unidad', ['producto' => $p],key(01.,'$p->id'))
                           </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
              
            </div>
            <div>
                {{$trasl->links()}}
            </div>

        @else
            <div class="card-body">
                <strong>No hay registros</strong>
            </div>
        @endif
</div>
