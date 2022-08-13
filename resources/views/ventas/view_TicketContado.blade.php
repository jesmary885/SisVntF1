<?php
$medidaTicket = 180;

?>
<!DOCTYPE html>
<html>

<head>

    <style>
        * {
            font-size: 12px;
            font-family: 'DejaVu Sans', serif;
        }

        h1 {
            font-size: 18px;
        }

        .ticket {
            margin: 2px;
        }

        td,
        th,
        tr,
        table {
            border-top: 1px solid black;
            border-collapse: collapse;
            margin: 0 auto;
        }

        td.precio {
            text-align: right;
            font-size: 11px;
        }

        td.cantidad {
            font-size: 11px;
        }

        
        .foo {
            font-size: 9px;
        }

        td.producto {
            text-align: center;
        }

        th {
            text-align: center;
        }


        .centrado {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: <?php echo $medidaTicket ?>px;
            max-width: <?php echo $medidaTicket ?>px;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        * {
            margin: 0;
            padding: 0;
        }

        .ticket {
            margin: 0;
            padding: 0;
        }
        .cant{
            padding-left: 4px;
        }

        body {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="ticket centrado">
        <h1>{{$empresa->nombre}}</h1>
        <p>RU: {{$empresa->nro_documento}} <br>
        {{$empresa->direccion}} <br>
        Telefono: {{$empresa->telefono}} <br>
        Email:  {{$empresa->email}}<br><br>
            <hr>
            Fecha: {{$fecha_actual}} <br>
            Cajero: {{$usuario}}
            <hr>
            Cliente:{{$cliente_nombre}}
            Documento:{{$cliente_documento}}
        </p>
        <table>
            <thead>
                <tr class="centrado">
                    <th class="cant">Cant </th>
                    <th class="producto">Descripción </th>
                    <th class="precio">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                        <tr>
                            <td class="cant">{{$producto->cantidad}}</td>
                            <td>{{$producto->producto->nombre}} - {{$producto->producto->modelo->nombre}}</td>
                            <td>S/ {{$producto->precio * $producto->cantidad}}</td>
                        </tr>
                    @endforeach
            </tbody>
            <tr>
                <td class="cantidad"></td>
                <td class="producto">
                    <strong>SUBTOTAL</strong>
                </td>
                <td class="precio">
                    <p>S/ {{$subtotal}}</p>
                </td>
            </tr>
            <tr>
                <td class="cantidad"></td>
                <td class="producto">
                    <strong>DESCUENTO</strong>
                </td>
                <td class="precio">
                    <p>S/ {{$descuento}}</p>
                </td>
            </tr>
            {{-- <tr>
                <td class="cantidad"></td>
                <td class="producto">
                    <strong>IMPUESTO</strong>
                </td>
                <td class="precio">
                    <p>S/ {{$impuesto}}</p>
                </td>
            </tr> --}}
            <tr>
                <td class="cantidad"></td>
                <td class="producto">
                    <strong>TOTAL</strong>
                </td>
                <td class="precio">
                    <p>S/ {{$total}}</p>
                </td>
            </tr>
        </table>
        <p class="foo">***Para realizar un reclamo o devolución<br>debe presentar este ticket***</p>
        <p class="centrado">¡GRACIAS POR SU COMPRA!</p>
    </div>
</body>

</html>