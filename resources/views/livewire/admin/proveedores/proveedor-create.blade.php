<div>
    <button type="submit" class="btn btn-primary btn-sm float-right" wire:click="open">
        @if ($accion == 'create')
        <i class="fas fa-user-plus"></i> Nuevo proveedor 
        @else
        <i class="fas fa-user-edit"></i>
        @endif
    </button>

    @if ($isopen)
        <div class="modal d-block" tabindex="-1" role="dialog" style="overflow-y: auto; display: block;"
            wire:click.self="$set('isopen', false)">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title py-0 text-lg text-gray-800"> <i class="fas fa-user-tie"></i>  Registro de proveedores</h5>
                    </div>
                    <div class="modal-body">
                        <h2 class="text-sm ml-2 m-0 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Complete todos los campos y presiona Guardar</h2> 
                        <h2 class="text-sm ml-2 m-0 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> El campo Email debe registrarlo completo, ejemplo: maria@gmail.com </h2> 
                        <hr>

                        <div class="flex mt-2 justify-between w-full">
                            <div class="w-3/4 mr-2">
                                <select wire:model="tipo_documento" id="tipo_documento" title="Tipo de documento"
                                    class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    name="tipo_documento">
                                    <option value="" selected>Doc.</option>
                                    <option value="Rif">Rif</option>
                                    <option value="Cedula">Cedula</option>
                                    <option value="Licencia">Licencia</option>
                                    <option value="Pasaporte">Pasaporte</option>
                                    <option value="DNI">DNI</option>
                                    <option value="Otro">Otro</option>
                                </select>
                                <x-input-error for="tipo_documento" />
                            </div>
                            <div class="w-full mr-2">
                                <input wire:model.defer="nro_documento" name="nro_documento" type="text" title="Nro de documento"
                                    class="px-2 appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    placeholder="Nro de documento">
                                <x-input-error for="nro_documento" />
                            </div>
                            <div class="w-full mr-2">
                                <input wire:model="telefono" type="number" title="Teléfono"
                                    class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    placeholder="Teléfono">
                                <x-input-error for="telefono" />
                            </div>
                        </div>

                        <div class="flex justify-between w-full mt-2 mr-2">
                            <div class="w-full mr-2">
                                <input wire:model="nombre_encargado" type="text" title="Nombre del encargado"
                                    class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    placeholder="Nombre del encargado">
                                <x-input-error for="nombre_encargado" />
                            </div>
                            <div class="w-full mr-2">
                                <input wire:model="nombre_proveedor" type="text" title="Nombre del proveedor"
                                    class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    placeholder="Nombre del proveedor">
                                <x-input-error for="nombre_proveedor" />
                            </div>
                        </div>

                        <div class="flex justify-between w-full mt-2 mr-2">

                            <div class="w-full mr-2">
                                <input wire:model="email" type="email" title="Email"
                                    class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    placeholder="E-mail">
                                <x-input-error for="email" />
                            </div>

                            <div class="w-full mr-2">
                                <input wire:model="direccion" type="text" title="Dirección"
                                    class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    placeholder="Dirección">
                                <x-input-error for="direccion" />
                            </div>

                        </div>

                        <div class="flex justify-between w-full mt-2">
                            <div class="w-full mr-2">
                                <select wire:model="estado_id" title="Estado/provincia/region"
                                    class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="" selected>Estado/provincia/region</option>
                                    @foreach ($estados as $estado)
                                        <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="estado_id" />
                               
                            </div>

                            <div class="w-full mr-2">
                                <select wire:model="ciudad_id" title="Ciudad"
                                class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="" selected>Seleccione la ciudad</option>
                                @foreach ($ciudades as $ciudad)
                                    <option value="{{ $ciudad->id }}">{{ $ciudad->nombre }}</option>
                                @endforeach
                            </select>
                            <x-input-error for="ciudad_id" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="close">Cerrar</button>
                        <button type="button" class="btn btn-primary" wire:click="save">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
