<div>
     <button title="Editar usuario" type="submit" class="btn btn-success btn-sm" wire:click="open">
        <i class="fas fa-user-edit"></i>
    </button> 

    @if($isopen)
    
    <div class="modal d-block" tabindex="-1" role="dialog" style="overflow-y: auto; display: block;" wire:click.self="$set('isopen', false)">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title py-0 text-lg text-gray-800"><i class="fas fa-user-tie"></i> Editar usuario</h5>
             
            </div>
            <div class="modal-body">
                <h2 class="text-sm ml-2 m-0 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Complete todos los campos y presiona Guardar</h2> 
            <h2 class="text-sm ml-2 m-0 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> El campo Email debe registrarlo completo, ejemplo: maria@gmail.com </h2> 
            <h2 class="text-sm ml-2 m-0 p-0 mb-2 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> La contraseña debe contener mínimo 6 y máximo 12 caracteres</h2> 
                <hr class="m-0 p-0">
                <div class="flex">
                    <i class="far fa-address-card mt-2 mr-1"></i>
                  <h2 class="inline text-base mt-1"> Información personal</h2>
               
              </div>
                <div class="flex mt-2 justify-between w-full">
                    <div class="w-full mr-2">
                      <select wire:model="tipo_documento" title="Tipo de documento" id="tipo_documento" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="tipo_documento">
                             <option value="" selected>Tipo de doc.</option>
                             <option value="1">Cedula</option>
                            <option value="2">Licencia</option>
                            <option value="3">Pasaporte</option>
                            <option value="4">Rif</option>
                            <option value="5">DNI</option>
                            <option value="6">Otro</option>
                         </select>
                         <x-input-error for="tipo_documento" />
                    </div>
                    <div class="w-full mr-2">
                        <input wire:model.defer="nro_documento" title="Nro de documento" name="nro_documento" type="number" class="px-2 appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Nro de documento">
                        <x-input-error for="nro_documento" />
                    </div>
                     <div class="w-full">
                      <input wire:model="telefono" type="number" title="Nro de teléfono" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Telefono">
                      <x-input-error for="telefono" />
                  </div>
                </div>

                <div class="flex justify-between w-full mt-3 mr-2">
                    <div class="w-full mr-2">
                        <input wire:model="name" type="text" title="Nombre" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Nombres">
                        <x-input-error for="name" />
                    </div>
                    <div class="w-full mr-2">
                        <input wire:model="apellido" type="text" title="Apellido" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Apellidos">
                        <x-input-error for="apellido" />
                    </div>
                </div>

                <div class="flex justify-between w-full mt-3 mr-2">
                 
                    

                    <div class="w-full mr-2">
                        <input wire:model="direccion" type="text" title="Dirección" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Dirección">
                        <x-input-error for="direccion" />
                    </div>
        
                </div>

                <div class="flex justify-between w-full mt-3 mr-2">
                    <div class="w-full mr-2">
                        <select wire:model="estado_id" title="Estado/provincia/región" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="" selected>Estado/provincia/region</option>
                             @foreach ($estados as $estado)
                                <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                            @endforeach 
                        </select>
                        <x-input-error for="estado_id" />
                    </div>
                    <div class="w-full">
                        <select wire:model="ciudad_id" title="Ciudad" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="" selected>Seleccione la ciudad</option>
                             @foreach ($ciudades as $ciudad)
                                <option value="{{$ciudad->id}}">{{$ciudad->nombre}}</option>
                            @endforeach
                        </select>
                        <x-input-error for="ciudad_id" />
                    </div>
                </div>
                <hr class="mb-0 pb-0">




                <div class="flex">
                    <i class="fas fa-user-lock mt-3 mr-1"></i>
                  <h2 class="inline text-base mt-3"> Información de la cuenta</h2>
              </div>
   
               <div class="flex justify-between w-full mt-3">
                    <div class="w-full mr-2">
                        <input wire:model="password" title="Contraseña" type="text" id="password" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Contraseña">
                        <x-input-error for="password" />
                    </div>
                    <div class="w-full mr-2">
                        <input wire:model="password_confirm" title="Confirmar contraseña" id="password_confirm" name="password_confirmation" type="text" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Repetir contraseña">
                        <x-input-error for="password_confirm" />
                    </div>
                </div>

                <div class="w-full mr-4 mt-3">
                    <input wire:model="email" type="email" title="Email" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="E-mail">
                    <x-input-error for="email" />
                </div>


                <div class="flex justify-between w-full mt-3 mr-2">
                    <div class="w-full mr-2">
                        <select wire:model="estado" title="Estado de la cuenta" id="estado" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="estado">
                            <option value="" selected>Estado de la cuenta</option>
                            <option value="1">Activa</option>
                            <option value="2">Inactiva</option>
                        </select>
                        <x-input-error for="estado" />
                    </div>
                    <div class="w-full">
                        <select wire:model="roles_id" title="Rol de usuario" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="" selected>Rol del usuario</option>
                                @foreach ($roles as $rol)
                            <option value="{{$rol->id}}">{{$rol->name}}</option>
                            @endforeach
                        </select>
                        <x-input-error for="roles_id" />
                    </div>
                </div>
                <hr class="mb-0 pb-0">

                <div class="flex">
                    <i class="fas fa-location-arrow mt-3 mr-1"></i>
                  <h2 class="inline text-base mt-2"> Zona de atención</h2>
              </div>

               <div class="flex justify-between w-full mt-3 mr-2">
                
                
                <div class="w-full mr-2">
                    <select wire:model="limitacion" title="Limitación de acceso" id="limitacion" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="estado">
                        <option value="" selected>Limitación de acceso</option>
                        <option value="1">Selección Libre</option>
                        <option value="2">Una sucursal</option>
                    </select>
                    <x-input-error for="limitacion" />
                </div>
                <div class="w-full">
                    <select wire:model="sucursales_id" title="Sucursal de atención" class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        <option value="" selected>Sucursal de atención</option>
                            @foreach ($sucursales as $sucursal)
                        <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                        @endforeach
                    </select>
                    <x-input-error for="sucursales_id" />
                </div>
                <hr class="mb-0 pb-0" >

            <div class="flex w-full h-full mt-1 ml-4">
                <input type="checkbox" class="ml-1 mt-1" wire:model="changePrice" value="1">
                <p class="text-sm font-semibold text-gray-500 ml-2">Permitir cambiar precios en venta</p>
            </div>
            
            </div>
        </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close" >Cerrar</button>
              <button type="button" class="btn btn-primary" wire:click="update">Guardar</button>
            </div>
          </div>
        </div>
    </div>

    @endif
</div>

