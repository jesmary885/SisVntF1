<div>
    <div class="card">
        <h1 class="py-0 text-lg text-gray-500 ml-4 mt-1"> <i class="fas fa-lock"></i> Reporte de totales (iva,exento y totales en venta)</h1>
    </div>

    <div class="card mb-1">
        <div class="card-body mt-0">
            <table class="table table-striped table-responsive-lg table-responsive-md table-responsive-sm">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">Cantidad de ventas</th>
                        <th class="text-center">Total de ganancia</th>
                        <th class="text-center">Total IVA</th>
                        <th class="text-center">Total Exento</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">{{$total_cant_ventas}}</td>
                        <td class="text-center">{{ $moneda_simbolo }}  {{round($total_ventas_ganancias/ $tasa_dia),2}}</td>
                        <td class="text-center">{{ $moneda_simbolo }}  {{ round($total_iva/ $tasa_dia),2}}</td>
                        <td class="text-center">{{ $moneda_simbolo }}  {{ round($total_exento/ $tasa_dia),2}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
 
                @if ($array_pago_metodos)

                <div class="card-body mt-0">
                    <div class="w-full text-center mt-2">
                        <p class="text-lg text-gray-600">Totales en métodos de pago</p>
                    </div>

                    <table class="table table-striped table-responsive-lg table-responsive-md table-responsive-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Método de pago</th>
                                <th class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($array_pago_metodos  as $value)
                                <tr>
                                    <td class=" text-center">
                                        {{$value['metodo_nombre']}}
                                    </td>
                                    <td class="text-center">
                                        {{ $moneda_simbolo }} {{ round( $value['quantity']/ $tasa_dia),2}}
                                    </td>
                                </tr>
                            @endforeach 
                        </tbody>
                    </table>
                </div>
            @endif  
        </div>

        <div class="card mt-1">
            <div class="m-3">
                <button class="btn btn-info btn-sm mt-2 ml-2" wire:click="export_pdf()" title="Exportar a PDF"> <i class="far fa-file-pdf"></i> Exportar a PDF</button>
            </div>
        </div>
</div>