<div>
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <div class="flex-1">
                <div class=flex>
                    <div class="w-1/4">
               
                        <select wire:model="buscador" id="buscador" class="form-control text-m" name="buscador">
                            <option value="0">Nombre producto</option>
                            <option value="1">Cód barra producto</option>
                            <option value="2">Usuario</option>
                        </select>
    
                        <x-input-error for="buscador" />

                    </div>
                    <input wire:model="search" placeholder="Ingrese {{$item_buscar}}" class="form-control ml-2">
                        
                </div>
                
            </div>
            
        </div>
     
        @if ($array)
            <div class="card-body">
                <table class="table table-bordered table-responsive-md table-responsive-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Producto (Cód barra /Nombre / Cat / Marc /Mod)</th>
                            <th class="text-center">U. Entrada</th>
                            <th class="text-center">Dinero</th>
                            <th class="text-center">U. Salida</th>
                            <th class="text-center">Dinero</th>
                            <th class="text-center">Stock pre.</th>
                            <th class="text-center">Stock post.</th>
                            <th class="text-center">Motivo</th>
                            <th class="text-center">Usuario</th>

                        </tr>
                    </thead>
                    <tbody>
                                
                        @foreach ($array as $value)
                        {{-- <tr>
                            <td class="text-center">{{$value['nombre']}} {{$value['categoria_nombre']}} {{$value['modelo_nombre']}} {{$value['marca_nombre']}}</td>
                            <td class="text-center">{{$value['quantity_entrada']}}</td>
                            <td class="text-center">{{$value['precie_entrada']}}</td>
                            <td class="text-center">{{$value['quantity_salida']}}</td>
                            <td class="text-center">{{$value['precie_salida']}}</td>
                        </tr> --}}
                        <tr>
                        <td class="text-center">{{$value->producto->nombre}} {{$value->producto->cod_barra}} {{$value->producto->categoria->nombre}} {{$value->producto->marca->nombre}} {{$value->producto->modelo->nombre}} </td>
                            <td class="text-center">{{$value->cantidad_entrada}}</td>
                            <td class="text-center">{{$value->precio_entrada * $value->cantidad_entrada}}</td>
                            <td class="text-center">{{$value->cantidad_salida}}</td>
                            <td class="text-center">{{$value->precio_salida * $value->cantidad_salida}}</td>
                            <td class="text-center">{{$value->stock_antiguo}}</td>
                            <td class="text-center">{{$value->stock_nuevo}}</td>
                            <td class="text-center">{{$value->detalle}}</td>
                            <td class="text-center">{{$value->user->name}}{{$value->user->apellido}}</td>
                        </tr>
                    @endforeach    
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{$array->links()}}
           
            </div>
        @else
             <div class="card-body">
                <strong>No hay registros</strong>
            </div>
        @endif
        <div class="flex justify-start">
         
                <div class="mt-2 ml-4 mb-2">
                    <a href="{{route('reportes.index.kardex')}}" class="btn btn-primary"><i class="fas fa-undo-alt"></i> Regresar</a>
                </div>
   
            <div>
                <button class="btn btn-success mt-2 ml-2 mb-2" wire:click="export" title="Exportar"> <i class="far fa-file-excel"></i> Exportar reporte</button>
            </div>

        </div>
        
</div>
