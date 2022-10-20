<div>
    <div class="card">
        <h1 class="py-0 text-lg text-gray-500 ml-4 mt-1"> <i class="fas fa-lock"></i> Productos por agotarse su existencia</h1>
    </div>

    <div class="card mb-1">

        @if ($productos)
                <div class="card-body mt-0">
                    <table class="table table-striped table-responsive-lg table-responsive-md table-responsive-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Código</th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Marc/Mod</th>
                                <th class="text-center">Lote</th>
                                <th class="text-center">Fecha de vencimiento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $producto)
                                <tr>
                                    <td class="text-center">{{$producto->cod_barra}}</td>
                                    <td class="text-center">{{$producto->nombre}}</td>
                                    <td class="text-center">{{$producto->marca}} / {{$producto->modelo}}</td>
                                    <td class="text-center">{{$producto->lote}}</td>
                                    <td class="text-center"> {{  \Carbon\Carbon::parse($producto->fecha_vencimiento)->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{$productos->links()}}
                        
                </div>
        @else
            <div class="card-body">
                <strong>No hay registros</strong>
            </div>
        @endif
    </div>

    @if ($productos->count())
        <div class="card mt-1">
            <div class="m-3">
                <button class="btn btn-info btn-sm mt-2 ml-2" wire:click="export_pdf()" title="Exportar a PDF"> <i class="far fa-file-pdf"></i> Exportar a PDF</button>
            </div>
        </div>
    @endif
</div>
