<div>
    <div class="card">
     
        @if ($traslados->count())
            <div class="card-body">
                <table class="table table-bordered table-responsive-md table-responsive-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Cantidad enviada</th>
                            <th class="text-center">Cantidad recibida</th>
                            <th class="text-center">Detalle inicial</th>
                            <th class="text-center">Detalle final</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($traslados as $traslado)
                        <?php
                            if($traslado->estado == 'PENDIENTE') $estado_bg = 'bg-red-400';
                            else $estado_bg = 'bg-green-400';
                        ?>
                            <tr class="{{$estado_bg}}">
                            
                                <td class="text-center">{{$traslado->fecha}}</td>
                                <td class="text-center">{{$traslado->producto->nombre}}
                                     {{$traslado->producto->marca->nombre}}
                                      {{$traslado->producto->modelo->nombre}}</td>
                                <td class="text-center">{{$traslado->cantidad_enviada}}</td>
                                <td class="text-center">{{$traslado->cantidad_recibida}}</td>
                                <td class="text-justify ">{{$traslado->observacion_inicial}}</td>
                                <td class="text-justify">{{$traslado->observacion_final}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{$traslados->links()}}
            </div>
        @else
             <div class="card-body">
                <strong>No hay registros</strong>
            </div>
        @endif
        <div class="flex justify-start">
         
                <div class="mt-2 ml-4 mb-2">
                    <a href="{{route('reportes.index.traslados')}}" class="btn btn-primary"><i class="fas fa-undo-alt"></i> Regresar</a>
                </div>
   
            <div>
                <button class="btn btn-success mt-2 ml-2 mb-2" wire:click="export" title="Exportar"> <i class="far fa-file-excel"></i> Exportar reporte</button>
            </div>

        </div>
        
</div>