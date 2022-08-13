
<p>Periodo del reporte de traslado:  {{$fecha_inicio}}  /  {{$fecha_fin}} </p>
<table class="table table-striped w-full">
    <thead>
        <tr class="text-gray-500 text-md font-bold bg-white rounded shadow-lg border h-8">
            <th>Fecha</th>
            <th>producto</th>
            <th>Cantidad enviada</th>
            <th>Cantidad recibida</th>
            <th>Detalle inicial</th>
            <th>Detalle final</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        
        @foreach ($traslados as $traslado)
            <tr class="py-2 border-collapse border border-gray-300">
                    <td class="text-center font-bold">{{$traslado->fecha}}</td>
                    <td class="text-center font-bold">{{$traslado->producto->nombre}} {{$traslado->producto->marca->nombre}} {{$traslado->producto->modelo->nombre}}</td>
                    <td class="text-center font-bold">{{$traslado->cantidad_enviada}}</td>
                    <td class="text-center font-bold">{{$traslado->cantidad_recibida}}</td>
                    <td class="text-center font-bold">{{$traslado->observacion_inicial}}</td>
                    <td class="text-center font-bold">{{$traslado->observacion_final}}</td>
                    <td class="text-center font-bold">{{$traslado->estado}}</td>
            </tr>
        @endforeach 
    </tbody>
</table>