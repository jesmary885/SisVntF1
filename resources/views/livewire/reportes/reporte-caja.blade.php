<div>

    <div class="card">
        @if ($movimientos->count())
            <div class="card-body">
                <table class="table table-bordered table-responsive-md table-responsive-sm">
                    <thead class="thead-dark">
              
                        <tr>
                            <th class="text-center">Fecha y hora</th>
                        
                                <th class="text-center">Sucursal</th>                                
                    
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
                                <td class="text-center">{{$movimiento->sucursal->nombre}}</td>                             
                                <td class="text-center">{{$tipoMovimiento}} </td>
                                <td class="text-justify ">{{$movimiento->cantidad}}</td>
                                <td class="text-justify">{{$movimiento->observacion}}</td>
                                <td class="text-justify">{{$movimiento->user->name}} {{$movimiento->user->apellido}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="flex">
                    <div>
                        <a href="{{route('reportes.index.caja')}}" class="btn btn-sm btn-dark mt-2 ml-2 justify-end"><i class="fas fa-undo-alt"></i> Regresar</a>
                    </div>

                    <div class="flex-1">
                        <button class="btn btn-success btn-sm mt-2 ml-2" wire:click="export_excel" title="Exportar a excel"> <i class="far fa-file-excel"></i> Exportar a excel</button>
                        <button class="btn btn-info btn-sm mt-2 ml-1" wire:click="export_pdf" title="Exportar a PDF"> <i class="far fa-file-pdf"></i> Exportar a PDF</button>
                    </div>
                    
                       
               
                </div>
            </div>
            <div class="card-footer">
                {{$movimientos->links()}}
            </div>
        @else
             <div class="card-body">
                 <div>
                    <strong>No hay registros</strong>

                    <div >
                        <a href="{{route('reportes.index.caja')}}" class="btn btn-primary m-4"><i class="fas fa-undo-alt"></i> Regresar</a> 
                    </div>
                 </div>
               
            </div>
        @endif

    </div>

        




</div>
