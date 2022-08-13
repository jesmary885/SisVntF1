
<p class="text-gray-500 text-md font-bold bg-white text-center rounded shadow-lg border h-8"> CLIENTES REGISTRADOS</p>
<table class="table table-striped w-full">
    <thead>
        <tr class="text-gray-500 text-md font-bold bg-white rounded shadow-lg border h-8">
            <th>Nombre</th>
            <th>Email</th>
            <th>Nro de documento</th>
            <th>Telefono</th>
            <th>Direccion</th>
            <th>Puntos acumulados</th>
            <th>Asesor de ventas</th>
        </tr>
    </thead>
    <tbody>
        
        @foreach ($clientes as $cliente)
            <tr class="py-2 border-collapse border border-gray-300">
                        <td class="py-2 text-center">{{$cliente->nombre}} {{$cliente->apellido}}</td>
                        <td class="text-center font-bold">{{$cliente->email}} </td>
                        <td class="text-center font-bold">{{$cliente->nro_documento}} </td>
                        <td class="text-center font-bold">{{$cliente->telefono}}</td>
                        <td class="text-center font-bold">{{$cliente->direccion}}</td>
                        <td class="text-center font-bold">{{$cliente->puntos}}</td>
                        <td class="text-center font-bold">{{$cliente->user->name}} {{$cliente->user->apellido}} </td>
            </tr>
        @endforeach 
    </tbody>
</table>