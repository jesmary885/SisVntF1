<div>
    <div class="card">
        <h1 class="py-0 text-lg text-gray-500 ml-4 mt-1"> <i class="fas fa-lock"></i> Cambio de contraseña</h1>
    </div>

    <div class="card w-full pt-0 m-0">
        <div class="card-body w-full pt-0 mt-0">

            <div class="flex mt-1">
                <i class="fas fa-user-lock mt-3 mr-1"></i>
               <h2 class="text-lg inline mt-2">Información requerida</h2>
           </div>

           <div class="flex justify-between w-full mt-3 mr-2">

            <div class="w-full mr-2">
                <input wire:model="old_password" type="password" id="old_password" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Contraseña anterior">
                <x-input-error for="old_password" />
            </div>

            <div class="w-full mr-2">
                <input wire:model="password" type="password" id="password" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Nueva contraseña">
                <x-input-error for="password" />
            </div>
            <div class="w-full mr-2">
                <input wire:model="password_confirmation" id="password_confirmation" name="password_confirmation" type="password" class="w-full px-2 appearance-none block bg-gray-100 text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Repetir contraseña">
                <x-input-error for="password_confirmation" />
            </div>

            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary" wire:click="update_password">
                    <i class="fas fa-file-download"></i> Guardar
                </button>
             
            </div>
        </div>
    </div>
</div>
                       
                      



                       
           
           