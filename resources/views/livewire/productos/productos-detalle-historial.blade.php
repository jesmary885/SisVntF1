<div>
        <div class="card">
         
            @if ($movimientos->count())
                <div class="card-body">
                    <table class="table table-bordered table-responsive-md table-responsive-sm">
                        <thead class="thead-dark">
                            <tr>
                           
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Tipo de movimiento</th>
                                <th class="text-center">Detalle</th>
                                <th class="text-center">Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($movimientos as $movimiento)
                                <tr>
                                
                                    <td class="text-center">{{$movimiento->fecha}}</td>
                                    <td class="text-center">{{$movimiento->tipo_movimiento}}</td>
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
            <div class="flex justify-start">
                @if ($vista == 'cod_barra')
                    <div class="mt-2 ml-4 mb-2">
                        <a href="{{route('movimientos.historial')}}" class="btn btn-primary"><i class="fas fa-undo-alt"></i> Regresar</a>
                    </div>
                @else
                    <div class="mt-2 ml-4 mb-2">
                        <a href="{{route('movimientos.historial_prod_serial')}}" class="btn btn-primary"><i class="fas fa-undo-alt"></i> Regresar</a>
                    </div>
                @endif
                <div>
                    <button class="btn btn-success mt-2 ml-2 mb-2" wire:click="export" title="Exportar"> <i class="far fa-file-excel"></i> Exportar historial</button>
                </div>

            </div>
            
</div>
