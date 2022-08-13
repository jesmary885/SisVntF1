
<p class="text-gray-500 text-md font-bold bg-white text-center rounded shadow-lg border h-8"> MOVIMIENTOS DE PRODUCTO {{$producto_nombre}} - COD DE BARRA {{$producto_cod_barra}} </p>
<p>Periodo de los movimientos:  {{$fecha_inicio}}  /  {{$fecha_fin}} </p>
<table class="table table-striped w-full">
    <thead>
        <tr class="text-gray-500 text-md font-bold bg-white rounded shadow-lg border h-8">
            <th>Fecha</th>
            <th>Tipo de movimiento</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Observaciones</th>
            <th>Usuario</th>
        </tr>
    </thead>
    <tbody>
        
        @foreach ($movimientos as $movimiento)
            <tr class="py-2 border-collapse border border-gray-300">
                    <td class="text-center font-bold">{{$movimiento->fecha}}</td>
                    <td class="text-center font-bold">{{$movimiento->tipo_movimiento}}</td>
                    <td class="text-center font-bold">{{$movimiento->cantidad}}</td>
                    <td class="text-center font-bold">{{$movimiento->precio}}</td>
                    <td class="text-center font-bold">{{$movimiento->observacion}}</td>
                    <td class="text-center font-bold">{{$movimiento->user->name}}</td>
            </tr>
        @endforeach 
    </tbody>
</table>