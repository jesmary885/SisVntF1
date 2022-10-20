<?php
$medidaTicket = 160;

?>
<!DOCTYPE html>
<html>

<head>

    <style>
        * {
            font-size: 8px;
            font-family: 'DejaVu Sans', serif;
        }

        h1 {
            font-size: 14px;
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

        .cant{
            padding-left: 2px;
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
            margin-left: 2px ;
            margin-top: 0px;
            margin-bottom: 0px;
            margin-right: 2px;
            padding: 0;
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
                @foreach ($collection as $item)
                        <tr>
                            <td class="cant">{{$item->qty}}</td>
                            @if($item->options['exento'] == "Si" )
                            <td>{{$item->name}} - {{$item->options['modelo']}} (E)</td>
                            @else
                            <td>{{$item->name}} - {{$item->options['modelo']}}</td>
                            @endif
                            <td>S/ {{$item->price}}</td>
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
            <tr>
                <td class="cantidad"></td>
                <td class="producto">
                    <strong>IVA ({{$iva_empresa}} %)</strong>
                </td>
                <td class="precio">
                    <p>S/ {{$iva}}</p>
                </td>
            </tr>
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