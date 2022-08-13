<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ventas del día</title>
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
                            <p>RUC: {{$empresa->nro_documento}} <br>
                                {{$empresa->direccion}} <br>
                                Telefono: {{$empresa->telefono}} <br>
                                Email:  {{$empresa->email}}<br><br>
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
            <p class="fechas">Ventas del día {{$fecha}} en sucursal {{$sucursal}}</p>
        </div>
        <div>
            <table id="facproducto">
                <thead>
                    <tr id="fa">
                        <th class="text-center">Tipo</th>
                          <th class="text-center">Total pagado</th>
                          <th class="text-center">Total en venta</th>
                          <th class="text-center">Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_contado = 0;
                    $total_credito = 0;
                    $total =0;

                    ?>
                    @foreach ($ventas as $venta)
                    <?php
                    
                    if($venta->tipo_pago == 1){
                        $tipo_pago = 'Contado';
                        $total_contado = $venta->total + $total_contado;

                    } 
                    else{
                        $tipo_pago = 'Credito';
                        $total_credito = $venta->total_pagado_cliente + $total_credito;
                    } 
                    ?>
                        <tr>
                            <td class="text-center">{{$tipo_pago}} </td>
                            <td class="text-center">{{$venta->total_pagado_cliente}}</td>
                            <td class="text-center">{{$venta->total}}</td>
                            <td class="text-center">{{$venta->user->name}} {{$venta->user->apellido}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p class="fechas">Totales</p>
            <table id="facproducto">
                <thead>
                    <tr id="fa">
                        <th class="text-center">Ventas a contado</th>
                        <th class="text-center">Ventas a credito</th>
                        <th class="text-center">Compras</th>
                        <th class="text-center">Total de ganancias</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td class="text-center">{{$total_contado}} </td>
                        <td class="text-center">{{$total_credito}}</td>
                        <td class="text-center">{{$total_compras}} </td>
                        <td class="text-center">{{($total_contado + $total_credito) - $total_compras}}</td>
                    </tr>
       
                </tbody>
            </table>

        </div>
    </section>
    <br>
    <br>

</body>
</html>