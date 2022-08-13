
<p>REPORTE DE MOVIMIENTO DE CAJAS ENTRE FECHAS:  {{$fecha_inicio}}  /  {{$fecha_fin}} </p>
<table class="table table-striped w-full">
    <thead>
        <tr class="text-gray-500 text-md font-bold bg-white rounded shadow-lg border h-8">
            <th>FECHA Y HORA</th>
            <th>SUCURSAL</th>
            <th>TIPO DE MOVIMIENTO</th>
            <th>CANTIDAD</th>
            <th>DETALLE</th>
            <th>USUARIO</th>
        
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
            <tr class="py-2 border-collapse border border-gray-300">
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