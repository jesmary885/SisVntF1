<div>
    <div class="card mb-1">
        <div class="card-header flex justify-between border-0">
            <h3 class="text-lg flex-1 tex-gray-700">Ventas del día en {{$usuario_ac}} </h3>
            <div class="card-tools">
            <a href="#" title="Descargar" wire:click="export_pdf" class="btn btn-tool btn-sm">
                <i class="fas fa-download"> 
                
                </i>
            </a>
        </div>
    </div>
    </div>

    <div class="card mt-0">
        @if ($ventas->count())
          <div class="card-body">
              <table class="table table-bordered ">
                  <thead class="thead-dark">
                      <tr>
                          <th class="text-center">Tipo</th>
                          <th class="text-center">Total pagado</th>
                          <th class="text-center">Total en venta</th>
                          <th class="text-center">Usuario</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($ventas as $venta)
                          <tr>
                              <td class="text-center">{{$venta->tipo_pago}} </td>
                              <td class="text-center">{{$venta->total_pagado_cliente}}</td>
                              <td class="text-center">{{$venta->total}}</td>
                              <td class="text-center">{{$venta->user->name}} {{$venta->user->apellido}}</td>
                          </tr>
                      @endforeach
                  </tbody>
            </table>
          </div>
          <div class="card-footer">
            {{$ventas->links()}}
          </div>
        @else
          <div class="card-body">
              <strong>No hay registros</strong>
          </div>
        @endif
    </div>


</div>
