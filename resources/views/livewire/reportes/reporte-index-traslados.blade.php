<div>
    <div class="card mt-2">

        <h5 class="modal-title py-0 text-lg ml-4 mt-4 text-gray-500"> <i class="fas fa-chart-pie"></i>  Reportes</h5>

        <hr>

        <div class="mt-2">
            <h2 class="text-sm ml-4 m-0 p-0 text-gray-500 font-semibold"><i class="fas fa-info-circle"></i> Ingrese el periodo de fechas, luego presiona Generar reporte</h2>
         
        </div>

        <hr>
      
    
        <div class="lg:flex justify-items-stretch w-full mt-2 mb-2 ml-4">
            <div>
                <x-input.date wire:model.lazy="fecha_inicio" id="fecha_inicio" placeholder="Seleccione la fecha inicio" class="px-4 outline-none"/>
                <x-input-error for="fecha_inicio"/>     
            </div>
            <p class="ml-2 mr-2 text-gray-700 font-semibold">-</p>
            <div>
                <x-input.date wire:model.lazy="fecha_fin" id="fecha_fin" placeholder="Seleccione la fecha fin" class="px-4 outline-none"/>
                <x-input-error for="fecha_fin"/>
            </div>
        </div>


            <div>
                <button type="button" class="ml-4 mt-4 mb-2 btn btn-primary disabled:opacity-25" wire:loading.attr="disabled" wire:click="buscar">Generar reporte</button> 
            </div>


    </div>

    


</div>

