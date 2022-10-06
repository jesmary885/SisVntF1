<div class="py-0 show" aria-labelledby="navbarVersionDropdown" style="left: 0px; right: inherit;">
     
    @foreach ($monedas as $moneda)
        <button class="block dropdown-item" wire:click="cambiar_moneda('{{$moneda->id}}')">{{ $moneda->nombre }}</button>
    @endforeach
                
</div>


