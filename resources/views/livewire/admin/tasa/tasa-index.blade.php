<div>
    <div class="card text-center w-full">
        <div class="card-body flex w-full flex-row items-center justify-center">
            <h2 class="first-line:text-center mr-2 text-gray-700 font-bold">
                {{$tasa->tasa}}
            </h2>
            @livewire('admin.tasa.tasa-edit', ['tasa' => $tasa])
        </div>
    </div>
</div>
