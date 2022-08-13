
<p class="text-gray-500 text-md font-bold bg-white text-center rounded shadow-lg border h-8"> REPORTE DE PRODUCTOS A FECHA {{$fecha_actual}}</p>
<table class="table table-striped w-full">
    <thead>
        <tr class="text-gray-500 text-md font-bold bg-white rounded shadow-lg border h-8">
            <th>Fecha de compra (Año-día-mes)</th>
            <th>Nombre</th>
            <th>Código de barra</th>
            <th>Serial</th>
            <th>Categoría</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Precio letal</th>
            <th>Precio al mayor</th>
            <th>Observaciones</th>

        </tr>
    </thead>
    <tbody>
        
        @foreach ($productos as $producto)
            <tr class="py-2 border-collapse border border-gray-300">
                <td class="py-2 text-center">{{$producto->fecha_compra}}</td>
                <td class="py-2 text-center">{{$producto->producto->nombre}}</td>
                <td class="text-center font-bold">{{$producto->producto->cod_barra}} </td>
                <td class="py-2 text-center">{{$producto->serial}}</td>
                <td class="text-center font-bold">{{$producto->categoria->nombre}} </td>
                <td class="text-center font-bold">{{$producto->marca->nombre}} </td>
                <td class="text-center font-bold">{{$producto->modelo->nombre}} </td>
                <td class="text-center font-bold">{{$producto->producto->precio_letal}} </td>
                <td class="text-center font-bold">{{$producto->producto->precio_mayor}} </td>
                <td class="text-center font-bold">{{$producto->producto->observaciones}} </td>
            </tr>
        @endforeach 
    </tbody>
</table>