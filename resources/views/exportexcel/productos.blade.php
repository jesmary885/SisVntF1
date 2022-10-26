
<p class="text-gray-500 text-md font-bold bg-white text-center rounded shadow-lg border h-8"> REPORTE DE PRODUCTOS A FECHA {{$fecha_actual}}</p>
    <table class="table table-striped w-full">
        <thead>
            <tr class="text-gray-500 text-md font-bold bg-white rounded shadow-lg border h-8">
                <th>Nombre</th>
                <th>Código de barra</th>
                <th>Categoría</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Cantidad</th>
                
            </tr>
        </thead>
        <tbody>
            
            @foreach ($productos as $producto)
                <tr class="py-2 border-collapse border border-gray-300">
                    @if ($relacion == 'sql')
                        <td class="py-2 text-center">{{$producto['nombre']}}</td>
                        <td class="text-center font-bold">{{$producto['cod_barra']}} </td>
                        <td class="text-center font-bold">{{($producto['categoria_nombre'])}} </td>
                        <td class="text-center font-bold">{{$producto['marca_nombre']}} </td>
                        <td class="text-center font-bold">{{$producto['modelo_nombre']}} </td>
                        <td class="text-center font-bold">{{$producto['quantity']}} </td>
                        
                    @else
                        @if ($sucursal != 0)
                        
                            <td class="py-2 text-center">{{$producto->nombre}}</td>
                            <td class="text-center font-bold">{{$producto->cod_barra}} </td>
                            <td class="text-center font-bold">{{$producto->categoria->nombre}} </td>
                            <td class="text-center font-bold">{{$producto->marca->nombre}} </td>
                            <td class="text-center font-bold">{{$producto->modelo->nombre}} </td>
                            <td class="text-center font-bold">{{$producto->cantidad}} </td>
                            
                        @else
                      
                            <td class="py-2 text-center">{{$producto->producto->nombre}}</td>
                            <td class="text-center font-bold">{{$producto->producto->cod_barra}} </td>
                            <td class="text-center font-bold">{{$producto->producto->categoria->nombre}} </td>
                            <td class="text-center font-bold">{{$producto->producto->marca->nombre}} </td>
                            <td class="text-center font-bold">{{$producto->producto->modelo->nombre}} </td>
                            <td class="text-center font-bold">{{$producto->cantidad}} </td>
                        @endif
                @endif
                </tr>
            @endforeach 
        </tbody>
    </table>