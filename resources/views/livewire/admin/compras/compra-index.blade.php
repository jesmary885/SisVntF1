<div>
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <div class="flex-1">
                <input wire:model="search" placeholder="Ingrese la fecha de la compra a buscar en formato Año-Mes-Día" class="form-control">
            </div>
            <div class="ml-2">
                <button
                    title="Ayuda a usuario"
                    class="btn btn-success btn-sm" 
                    wire:click="ayuda"><i class="fas fa-info"></i>
                    Guía rápida
                </button>
            </div>
            
        </div>
        @if ($compras->count())
            <div class="card-body">
                <table class="table table-striped table-responsive-lg table-responsive-md table-responsive-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Precio de compra</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Sucursal</th>
                   
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($compras as $compra)
                            <tr>
                                <td class="text-center">{{$compra->fecha}}</td>
                                <td class="text-center">{{$compra->producto->nombre}} - Cod. barra: {{$compra->producto->cod_barra}}</td>
                                <td class="text-center">{{$compra->cantidad}}</td>
                                <td class="text-center">{{$compra->precio_compra}}</td>
                                <td class="text-center">{{$compra->total}}</td>
                                <td class="text-center">{{$compra->sucursal->nombre}}</td>
                                {{-- <td width="10px">
                                    @livewire('admin.compras.compras-edit',['compra' => $compra],key($compra->id))
                                </td> --}}
                                {{-- <td width="10px">
                                    <button
                                        title="Eliminar compra"
                                        class="btn btn-danger btn-sm" 
                                        wire:click="delete('{{$compra->id}}')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{$compras->links()}}
            </div>
        @else
             <div class="card-body">
                <strong>No hay registros</strong>
            </div>
        @endif
            
    </div>
</div>