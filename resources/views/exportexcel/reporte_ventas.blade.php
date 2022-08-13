
<p>REPORTE DE VENTAS ENTRE FECHAS:  {{$fecha_inicio}}  /  {{$fecha_fin}} </p>
<table class="table table-striped w-full">
    <thead>
        <tr class="text-gray-500 text-md font-bold bg-white rounded shadow-lg border h-8">
            <th>VENTAS REALIZADAS</th>
            <th>TOTAL EN VENTAS</th>
            <th>COSTO EN VENTAS</th>
            <th>GANANCIAS</th>
        
        </tr>
    </thead>
    <tbody>
            <tr class="py-2 border-collapse border border-gray-300">
                    <td class="text-center font-bold">{{$ventas_realizadas}}</td>
                    <td class="text-center font-bold">{{$total_ventas}}</td>
                    <td class="text-center font-bold">{{$total_costos}}</td>
                    <td class="text-center font-bold">{{$total_ganancias}}</td>
            </tr>

    </tbody>
</table>