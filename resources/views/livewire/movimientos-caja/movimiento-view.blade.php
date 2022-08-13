<div>

    <div class="card">
        <div class="card-header flex items-center justify-between">
            <div class="flex-1">
                <div class="flex">
                    <div class="w-1/4">
                        <select wire:model="buscador" id="buscador" class="form-control text-m" name="buscador">
                            <option value="0">Usuario</option>
                            <option value="1">Fecha</option>
                        </select>
    
                        <x-input-error for="buscador" />

                    </div>


                    <input wire:model="search" placeholder="Ingrese el detalle del movimiento a buscar" class="form-control">

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
            <div class="ml-2">
                @livewire('movimientos-caja.movimiento-new',['sucursal' => $sucursal]) 
            </div>

        </div>
        @if ($movimientos->count())
            <div class="card-body">
                <table class="table table-bordered ">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Tipo de movimiento</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Detalle</th>
                            <th class="text-center">Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($movimientos as $movimiento)
                            <?php
                            if($movimiento->tipo_movimiento == 1){
                                 $tipoMovimiento = 'Ingreso';
                                 $tipoMovimiento_bg = 'bg-green-200';
                            }
                            elseif($movimiento->tipo_movimiento == 2) {
                                $tipoMovimiento = 'Egreso';
                                $tipoMovimiento_bg = 'bg-red-200';
                            }
                            else{
                                $tipoMovimiento = 'Transferencia';
                                $tipoMovimiento_bg = 'bg-yellow-200';
                            }
                            ?>

                            <tr class="{{$tipoMovimiento_bg}}">
                                <td class="text-center">{{$movimiento->fecha}}</td>
                                <td class="text-center">{{$tipoMovimiento}} </td>
                                <td class="text-center">{{$movimiento->cantidad}}</td>
                                <td class="text-center">{{$movimiento->observacion}}</td>
                                <td class="text-center">{{$movimiento->user->name}} {{$movimiento->user->apellido}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
               
            </div>
            <div class="card-footer">
                {{$movimientos->links()}}
            </div>
        @else
             <div class="card-body">
                <strong>No hay registros</strong>
            </div>
        @endif
            
    </div>
</div>
