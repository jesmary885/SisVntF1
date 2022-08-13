<div class="form-group">
    {!! Form::label('name', 'Nombre') !!}
    {!! Form::text('name', null, ['class' => 'form-control','placeholder' => 'Ingrese el nombre del rol']) !!}
    @error('name')
        <small class="text-danger">
            {{$message}}
        </small>
    @enderror
</div>
<h2 class="text-sm ml-2 m-0 mb-4 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Seleccione los permisos del rol y presiona Guardar</h2> 
@foreach ($permissions as $permission)
        <div>
            <label>
                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-1']) !!}
                {{$permission->description}}
            </label>
        </div>
@endforeach