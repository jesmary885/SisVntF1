<div>
    <div class="card mb-1">
        <div class="card-header flex justify-between border-0">
          <h3 class="text-lg flex-1 tex-gray-700">Movimientos del día en turno</h3>
          <div class="card-tools">
            <a href="#" title="Descargar" wire:click="export_pdf" class="btn btn-tool btn-sm">
              <i class="fas fa-download">
          
              </i>
            </a>
  
          </div>
        </div>
    </div>



    <div class="card mt-0">
        @if ($movimientos != '0')
          <div class="card-body">
              <table class="table table-bordered ">
                  <thead class="thead-dark">
                      <tr>
                          <th class="text-center">Tipo</th>
                          <th class="text-center">Cantidad</th>
                          <th class="text-center">Detalle</th>
                         
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($movimientos as $movimiento)
                          <?php
                          if($movimiento->tipo_movimiento == 1){
                              $tipoMovimiento = 'Ingreso';
                              $tipoMovimiento_bg = 'bg-green-200';
                          }
                          if($movimiento->tipo_movimiento == 2){
                              $tipoMovimiento = 'Egreso';
                              $tipoMovimiento_bg = 'bg-red-200';
                          }
                         
                          ?>
  
                          <tr class="{{$tipoMovimiento_bg}}">
                              <td class="text-center">{{$tipoMovimiento}} </td>
                              <td class="text-center">{{ $moneda_simbolo }} {{round(($movimiento->cantidad/ $tasa_dia),2)}}</td>
                              <td class="text-center">{{$movimiento->observacion}}</td>
                              
                          </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
          <div class="card-footer">
            {{$movimientos->links()}}
          </div>
        @else
          <div class="card-body">
              <strong>No hay registros</strong>
          </div>
        @endif
      </div>
   
</div>
