<div>
    <div class="flex justify-between w-full">
        <div>                   
            <input wire:model="qty" autofocus type="number" min="1" class="inputNumber text-center appearance-none block text-gray-700 border border-gray-200 rounded py-1 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="{{$qty}}">                   
        </div>
        <div> 
            <button type="submit" class="btn btn-primary btn-sm ml-2" 
                wire:click="edit_cant"
                wire:loading.attr="disabled"
                wire:target="edit_cant">
                <i class="fas fa-edit"></i>
            </button> 
        </div>
    </div>                           
</div>
