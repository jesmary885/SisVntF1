<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Facturacion</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px
        }

        #datos{
            text-align: left;
            float: left;
            margin-top: 0%;
            margin-left: 0%;
            margin-right: 0%;
           
        }

        #datos p{
            text-align: left;

           
        }

        #fo{
            text-align: center;
            font-size: 10px;
        }

        #encabezado {
            text-align: left;
            margin-left: 35%;
            margin-right: 35%;
            font-size: 15px;
        }

        #fact{
            float: right;
            text-align: center;
            margin-top: 2%;
            margin-left: 2px;
            margin-right: 2px;
            font-size: 20px;
            background: #33afff;
            border-radius: 8px;
            font-weight: bold;
        }

        #fact p{
         
            margin-left: 5px;
            margin-right: 5px;
          
        }

        #cliente{
            text-align: left;
        }

        section{
            clear: left;
        }

        #fact,
        #fv,
        #fa {
            color: #ffffff;
            font-size: 15px;            
        }

        #faproveedor {
            width: 40%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 15px;
        }


        #faproveedor thead{
            padding: 20px;
            background: #33afff;
            text-align: left;
            border-bottom: 1px solid #ffffff;

        }

        #faccomprador {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            border-spacing: 0;
            margin-bottom: 15px;
        }

        #faccomprador thead{
            padding: 20px;
            background: #33afff;
            text-align: center;
            border-bottom: 1px solid #ffffff;

        }

        #facproducto {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            text-align: center;
            border: 1px solid #000;
            margin-bottom: 15px;
        }

        #facproducto thead{
            padding: 20px;
            background: #33afff;
            text-align: center;
            border-bottom: 1px solid #ffffff;
        }

        img{
            margin-left: 0%;
            width: 115px;
        }


    </style>
</head>
<body>
    <header>
        <div>
            <img src="storage/logo/logo.png" alt="logo">
        </div>
        <div>
            <table id="datos">
                <thead>
                    <tr>
                      <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>
                            <p>RU: {{$empresa->nro_documento}} <br>
                                {{$empresa->direccion}} <br>
                                Telefono: {{$empresa->telefono}} <br>
                                Email:  {{$empresa->email}}<br><br>
                                Fecha de emision: {{$fecha_actual}} <br>
                                Cajero: {{$usuario}}
                            </p>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="fact">
            <p>FACTURA NRO.</p>
            <p>{{$venta_nro}}</p>
        </div>
    </header>
    <br>
    <br>
    <br>
    <br>
    <section>
        <div>
            <table id="faccomprador">
                <thead>
                    <tr id="fv">
                        <th>Cliente</th>
                        <th>Documento</th>
                        <th>Telefono</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$cliente_nombre}}</td>
                        <td>{{$cliente_documento}}</td>
                        <td>{{$cliente_telefono}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
    <br>
    <section>
        <div>
            <table id="facproducto">
                <thead>
                    <tr id="fa">
                        <th>Cantidad</th>
                        <th>Descripcion</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr>
                            <td>{{$producto->cantidad}}</td>
                            
                            <td>{{$producto->producto->nombre}} - {{$producto->producto->modelo->nombre}}</td>
                            <td>S/ {{$producto->precio}}</td>
                            <td>S/ {{$producto->precio * $producto->cantidad}} </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">
                            <p align="right">SUBTOTAL: </p>
                        </th>
                        <td>
                            <p align="center">S/ {{$subtotal}}</p>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="3">
                            <p align="right">DESCUENTO: </p>
                        </th>
                        <td>
                            <p align="center">S/ {{$descuento}}</p>
                        </td>
                    </tr>
                    {{-- <tr>
                        <th colspan="3">
                            <p align="right">IMPUESTO ({{$iva * 100}} %): </p>
                        </th>
                        <td>
                            <p align="center">S/ {{$impuesto}}</p>
                        </td>
                    </tr> --}}
                    <tr>
                        <th colspan="3">
                            <p align="right">TOTAL A PAGAR: </p>
                        </th>
                        <td>
                            <p align="center">S/ {{$total}}</p>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
    <br>
    <br>
    <footer id="fo">

      
        <p>
            ***Precios de productos incluyen impuestos. Para poder realizar un reclamo o devolucion debe presentar esta factura***
        </p>
    </footer>

    
</body>
</html>