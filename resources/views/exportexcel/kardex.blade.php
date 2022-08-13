
<p class="text-gray-500 text-md font-bold bg-white text-center rounded shadow-lg border h-8"> KARDEX </p>
<p>Periodo:  {{$fecha_inicio}}  /  {{$fecha_fin}} </p>
<table class="table table-striped w-full">
    <thead>
        <tr class="text-gray-500 text-md font-bold bg-white rounded shadow-lg border h-8">
            <th class="text-center">Producto (Cód barra /Nombre / Cat / Marc /Mod)</th>
                            <th class="text-center">U. Entrada</th>
                            <th class="text-center">Dinero</th>
                            <th class="text-center">U. Salida</th>
                            <th class="text-center">Dinero</th>
                            <th class="text-center">Stock pre.</th>
                            <th class="text-center">Stock post.</th>
                            <th class="text-center">Motivo</th>
                            <th class="text-center">Usuario</th>
        </tr>
    </thead>
    <tbody>
        
        @foreach ($movimientos as $value)
            <tr class="py-2 border-collapse border border-gray-300">
                <td class="text-center">{{$value->producto->nombre}} {{$value->producto->cod_barra}} {{$value->producto->categoria->nombre}} {{$value->producto->marca->nombre}} {{$value->producto->modelo->nombre}} </td>
                <td class="text-center">{{$value->cantidad_entrada}}</td>
                <td class="text-center">{{$value->precio_entrada}}</td>
                <td class="text-center">{{$value->cantidad_salida}}</td>
                <td class="text-center">{{$value->precio_salida}}</td>
                <td class="text-center">{{$value->stock_antiguo}}</td>
                <td class="text-center">{{$value->stock_nuevo}}</td>
                <td class="text-center">{{$value->detalle}}</td>
                <td class="text-center">{{$value->user->name}}{{$value->user->apellido}}</td>
            </tr>
        @endforeach 
    </tbody>
</table>