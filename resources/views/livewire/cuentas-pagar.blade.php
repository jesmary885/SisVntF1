<div>
    <div class="card">
        <h1 class="py-0 text-lg text-gray-500 ml-4 mt-1"> <i class="fas fa-lock"></i> Cuentas por pagar</h1>
    </div>

    <div class="card mb-1">

        @if ($cuentas->count())
                <div class="card-body mt-0">
                    <table class="table table-striped table-responsive-lg table-responsive-md table-responsive-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Compra Nro</th>
                                <th class="text-center">Sucursal de compra</th>
                                <th class="text-center">Proveedor</th>
                                <th class="text-center">Deuda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cuentas as $cuenta)
                                <tr>
                                    <td class="text-center">{{  \Carbon\Carbon::parse($cuenta->fecha)->format('d-m-Y') }}</td>
                                    <td class="text-center">{{$cuenta->id}}</td>
                                    <td class="text-center">{{$cuenta->sucursal->nombre}}</td>
                                    <td class="text-center">{{$cuenta->proveedor->nombre_proveedor}}</td>
                                    <td class="text-center">{{ $moneda_simbolo }} {{ round(($cuenta->deuda_a_proveedor/ $tasa_dia),2)}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center text-gray-800 font-bold">{{ $moneda_simbolo }} {{round(($total/ $tasa_dia),2)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{$cuentas->links()}}
                        
                </div>
        @else
            <div class="card-body">
                <strong>No hay registros</strong>
            </div>
        @endif
    </div>

    @if ($cuentas->count())
        <div class="card mt-1">
            <div class="m-3">
                <button class="btn btn-info btn-sm mt-2 ml-2" wire:click="export_pdf()" title="Exportar a PDF"> <i class="far fa-file-pdf"></i> Exportar a PDF</button>
            </div>
        </div>
    @endif
</div>
