<div>
    <div class="card">
        <div class="card-heade bg-gray-700">
            @if ($vista == 'ventas')
                <h2 class="text-lg text-white text-center bg-gray-700">Seleccione la sucursal en donde realizara la venta</h2>
            @elseif($vista == 'productos_enviar')
            <h2 class="text-lg text-white text-center bg-gray-700">Seleccione la sucursal donde esta el equipo a trasladar</h2>
            @elseif($vista == 'productos_recibir')
            <h2 class="text-lg text-white text-center bg-gray-700">Seleccione la sucursal donde estan los equipos a recibir</h2>
            @elseif($vista == 'ver_ventas')
            <h2 class="text-lg text-white text-center bg-gray-700">Seleccione la sucursal en donde desea ver las ventas</h2>
            @elseif($vista == 'cajas')
            <h2 class="text-lg text-white text-center bg-gray-700">Seleccione la sucursal en donde desea ver los movimientos</h2>
            @elseif($vista == 'cajas_pendiente')
            <h2 class="text-lg text-white text-center bg-gray-700">Seleccione la sucursal en donde desea ver los movimientos</h2>
            @elseif($vista == 'ver_ventas_cliente')
            <h2 class="text-lg text-white text-center bg-gray-700">Seleccione la sucursal en donde desea ver las ventas</h2>
            @else <h2 class="text-lg text-white text-center bg-gray-700">Seleccione el almacen</h2>
            @endif
            
        </div>
        @if ($sucursales->count())
            <div class="card-body">
                <th><h2 class="text-sm ml-2 mb-2 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Haga click sobre el nombre de la sucursal</h2> </th>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sucursales as $sucursal)
                            <tr>
                                {{-- <td class="text-center">{{ $sucursal->nombre}}</td> --}}
                                <td width="10px">
                                   
                                    <td class="text-center text-lg">
                                        @if ($vista == 'ventas')
                                        <a class="text-gray-600" href="{{route('ventas.seleccio',['sucursal'=>$sucursal,'proforma'=>$proforma])}}">{{$sucursal->nombre}}</a>
                                        {{-- <a href="{{route('ventas.ventas.edit',$sucursal)}}" class="btn btn-primary btn-sm"><i class="fas fa-check"></i></a> --}}
                                        @elseif($vista == 'productos_recibir')
                                        <a class="text-gray-600" href="{{route('productos.traslado.select',$sucursal)}}">{{$sucursal->nombre}}</a>
                                        @elseif($vista == 'productos_enviar')
                                        <a class="text-gray-600" href="{{route('productos.traslado.select.enviar',$sucursal)}}">{{$sucursal->nombre}}</a>
                                        @elseif($vista == 'cajas')
                                        <a class="text-gray-600" href="{{route('movimiento.caja.view',$sucursal)}}">{{$sucursal->nombre}}</a>
                                        {{-- <a href="{{route('productos.traslado.select',$sucursal)}}" class="btn btn-primary btn-sm"><i class="fas fa-check"></i></a> --}}
                                        @elseif($vista == 'cajas_pendiente')
                                        <a class="text-gray-600" href="{{route('movimiento.caja_pendiente.view',$sucursal)}}">{{$sucursal->nombre}}</a>
                                        @elseif($vista == 'ver_ventas')
                                        <a class="text-gray-600" href="{{route('mostrar.ventas',['sucursal'=>$sucursal,'tipo'=>$proforma])}}">{{$sucursal->nombre}}</a>
                                        @elseif($vista == 'ver_ventas_cliente')
                                        <a class="text-gray-600" href="{{route('ventas.clientes.view',['sucursal'=>$sucursal])}}">{{$sucursal->nombre}}</a>
                                        @else
                                    <a class="text-gray-600" href="{{route('productos.serial.view',$sucursal)}}">{{$sucursal->nombre}}</a>
                                        {{-- <a href="{{route('productos.serial.view',$sucursal)}}" class="btn btn-primary btn-sm"><i class="fas fa-check"></i></a> --}}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="card-body">
                <strong>No hay registros</strong>
            </div>
        @endif
    </div>
</div>
