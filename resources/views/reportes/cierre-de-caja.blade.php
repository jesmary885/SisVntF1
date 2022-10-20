<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de cierre de caja</title>
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

        .fechas{
            text-align: center;
            font-weight: bold;

           
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
            margin-left: 2%;
            margin-right: 2%;
            font-size: 20px;
            background: #33afff;
            border-radius: 8px;
            font-weight: bold;
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
                            <p>
                                Sucursal: {{$sucursal}} <br>
                                Caja: {{$caja}}<br>
                                Cajero: {{$cajero}}<br>
                                Fecha y hora de apertura: {{$fecha_apertura}}<br>
                                Fecha y hora de cierre: {{$fecha_cierre}}
                            </p>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </header>
    <br>
    <br>
    <br>
    <br>

    <section>
        <div>
            <p class="fechas">REPORTE DE CIERRE DE CAJA</p>
        </div>

     
        <div>
            <table id="facproducto">
                <thead>
                    <tr id="fa">
                        <th>Tipo de dato</th>
                        <th>Cantidad en bolivares</th>
                        <th>Cantidad en dólares</th>
                        <th>Observación de apertura</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td>Inicial</td>
                            <td>{{$inicial_bolivares->cantidad}}</td>
                            <td>{{$inicial_dolares->cantidad}}</td>
                            <td>{{$movimiento['observacion']}}</td>
                        </tr>
                        <tr>
                            <td>Final o acumulado</td>
                            <td>{{$movimiento['caja']['saldo_bolivares']}}</td>
                            <td>{{$movimiento['caja']['saldo_dolares']}}</td>
                            <td>-</td>
                        </tr>
                </tbody>
            </table>
        </div>

        <div>
            <p class="fechas">DATOS DE CIERRE</p>
        </div>

        <div>
            <table id="facproducto">
                <thead>
                    <tr id="fa">
                        <th>Tipo de movimiento</th>
                        <th>Método de pago</th>
                        <th>Monto</th>
          
                    </tr>
                </thead>
                <tbody>
                @if ($array)
                    @foreach ($array as $value)
                        <tr>
                            <td>Ingreso</td>
                            <td>{{$value['metodo_nombre']}}</td>
                            <td>{{$value['quantity']}}</td>
                        </tr>
                    @endforeach
                @endif  
                @if ($array_cambios)
                    @foreach ($array_cambios as $value)
                        <tr>
                            <td> Cambio a cliente</td>
                            <td>{{$value['metodo_nombre']}}</td>
                            <td>{{$value['quantity_vueltos']}}</td>
                        </tr>
                    @endforeach
                @endif  
                @if ($array_compras)
                    @foreach ($array_compras as $value)
                        <tr>
                            <td>Egreso por compra</td>
                            <td>{{$value['metodo_nombre']}}</td>
                            <td>{{$value['quantity']}}</td>
                        </tr>
                    @endforeach
                @endif  
                      
                </tbody>
            </table>
        </div>

    </section>
    <br>
    <br>

</body>
</html>