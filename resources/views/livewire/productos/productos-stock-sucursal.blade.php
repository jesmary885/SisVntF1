<div class="m-0 p-0 font-semibold text-gray-800 text-sm">
  

  {{$producto->cantidad}}  <a href="#" class="text-gray-800" wire:click="open">  <i class="fas fa-warehouse"></i></a>
   

   @if($isopen)
        <div class="modal d-block" tabindex="-1" role="dialog" style="overflow-y: auto; display: block;" wire:click.self="$set('isopen', false)">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title py-0 text-lg text-gray-800"> <i class="fas fa-warehouse"></i>  Stock del producto por sucursal</h5>

                       
      
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">Sucursal</th>
                                    <th class="text-center">Stock</th>
                            
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sucursales as $sucursal)
                                    <tr>
                                        <td class="text-center">{{$sucursal->nombre}}</td>
                                        <td class="text-center">@if($producto->sucursals->find($sucursal)->pivot->cantidad) {{$producto->sucursals->find($sucursal)->pivot->cantidad}}@endif</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close" >Cerrar</button>

                    </div>
                </div>
              
            </div>
            
        </div>
   @endif
</div>
