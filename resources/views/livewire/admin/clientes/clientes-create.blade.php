<div x-data="{tipo_documento: @entangle('tipo_documento')}">
    <button type="submit" class="btn btn-primary btn-sm"
        @if ($accion == 'create')
            title = "Registro de cliente"
        @else
            title="Editar cliente"
        @endif
        
        wire:click="open">

        @if ($accion == 'create')
        <i class="fas fa-user-plus"></i>
         
        Nuevo cliente
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
           
                        <h5 class="modal-title py-0 text-lg text-gray-800"> <i class="fas fa-user-tie"></i>  Registro de clientes</h5>
                    </div>
                    <div class="modal-body">
                        <h2 class="text-sm ml-2 m-0 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Complete todos los campos y presiona Guardar</h2> 
                        <h2 class="text-sm ml-2 m-0 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> El campo Email debe registrarlo completo, ejemplo: maria@gmail.com </h2> 
                        <hr>
                        <div class="flex mt-2 justify-between w-full">
                            <div class="w-3/4 mr-2">
                                <select wire:model="tipo_documento" id="tipo_documento"
                                    class="block w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    name="tipo_documento" title="Tipo de documento">
                                    <option value="" selected>*Doc.</option>
                                    <option value="Cedula">Cedula</option>
                                    <option value="Rif">Rif</option>
                                    <option value="Licencia">Licencia</option>
                                    <option value="Pasaporte">Pasaporte</option>
                                    <option value="DNI">DNI</option>
                                    <option value="Otro">Otro</option>
                                </select>
                                <x-input-error for="tipo_documento" />
                            </div>
                            <div class="w-full mr-2">
                                <input wire:model.defer="nro_documento" name="documento" type="text"
                                    class="px-2 appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    placeholder="*Nro de documento" title="Nro de documento">
                                <x-input-error for="nro_documento" />
                            </div>

                            <div class="mr-2" :class="{'hidden': tipo_documento != 1}">
                            <button type="button" class="btn btn-primary btn-sm" wire:click="buscar_dni"> <i class="fas fa-search"></i></button>
                            </div>
                        </div>

                        <div class="flex justify-between w-full mt-2 mr-2">
                            <div class="w-full mr-2">
                                <input wire:model="nombre" type="text"
                                    class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    placeholder="*Nombres" title="Nombre">
                                <x-input-error for="nombre" />
                            </div>
                            <div class="w-full mr-2">
                                <input wire:model="apellido" type="text"
                                    class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    placeholder="*Apellidos" title="Apellido">
                                <x-input-error for="apellido" />
                            </div>
                        </div>

                        <div class="flex justify-between w-full mt-2 mr-2">

                            
                            <div class="w-full mr-2">
                                <input wire:model="telefono" type="number"
                                    class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    placeholder="Teléfono" title="Teléfono">
                                <x-input-error for="telefono" />
                            </div>

                            <div class="w-full mr-2">
                                <input wire:model="direccion" type="text"
                                    class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    placeholder="*Dirección" title="Dirección">
                                <x-input-error for="direccion" />
                            </div>

                        </div>

                        <div class="flex justify-between w-full mt-2 mr-2">

                            <div class="w-full mr-2">
                                <input wire:model="email" type="email"
                                    class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    placeholder="E-mail" title="E-mail">
                                <x-input-error for="email" />
                            </div>
                        </div>

                        <div class="flex justify-between w-full mt-2">
                            <div class="w-full mr-2">
                                        <select title="Estado/provincia/region" wire:model="estado_id"
                                class="w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="" selected>Estado/provincia/region</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                @endforeach
                            </select>
                            <x-input-error for="estado_id" />
                            </div>
                            <div class="w-full mr-2">
                            <select title="Ciudad" wire:model="ciudad_id"
                                    class="w-full bg-gray-100 border border-gray-200 text-gray-400 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
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
                        <button  wire:loading.attr="disabled" type="button" class="btn btn-primary" wire:click="save">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- <script type="text/javascript">
    $(document).ready(function(){

        $('#btnbuscar').click(function(){
            var numdni=$('#dni').val();
            if (numdni!='') {
                $.ajax({
                    url:"{{ route('admin.clientes.store') }}",
                    method:'GET',
                    data:{dni:numdni},
                    dataType:'json',
                    success:function(data){
                        var resultados=data.estado;
                        if (resultados==true) {
                            $('#txtdni').val(data.dni);
                            $('#txtnombres').val(data.nombres);
                            $('#txtapellidos').val(data.apellidos);
                            $('#txtgrupo').val(data.grupovota);
                            $('#txtdistrito').val(data.distrito);
                            $('#txtprovincia').val(data.provincia);
                            $('#txtdepartamento').val(data.departamento);
                        }else{
                            $('#txtdni').val('');
                            $('#txtnombres').val('');
                            $('#txtapellidos').val('');
                            $('#txtgrupo').val('');
                            $('#txtdistrito').val('');
                            $('#txtprovincia').val('');
                            $('#txtdepartamento').val('');                            
                            $('#mensaje').show();
                            $('#mensaje').delay(2000).hide(2500);
                        }
                    }
                });
            }else{
                alert('Escriba el DNI.!');
                $('#dni').focus();
            }
            
        });

    });
    
</script> --}}
