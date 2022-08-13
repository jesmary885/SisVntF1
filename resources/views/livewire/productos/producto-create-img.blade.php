<div>
    <div class="mb-4" wire:ignore>
        <form action="{{ route('productos.files', $producto) }}" method="POST" class="dropzone"
            id="my-awesome-dropzone"></form>
    </div>

    <div>
        @if ($producto->images->count())
            <section class="bg-white shadow-xl rounded-lg p-6 mb-4">
                <h1 class="text-2xl text-center font-semibold mb-2">Imagenes del producto</h1>

                <ul class="flex flex-wrap">
                    @foreach ($producto->images as $image)

                        <li class="relative" wire:key="image-{{ $image->id }}">
                            <img class="w-32 h-20 object-cover" src="{{ Storage::url($image->url) }}" alt="">
                            <danger-button class="absolute right-2 top-2"
                                wire:click="deleteImage({{ $image->id }})" wire:loading.attr="disabled"
                                wire:target="deleteImage({{ $image->id }})">
                                x
                            </danger-button>
                        </li>

                    @endforeach

                </ul>
            </section>
        @endif
    </div>

   
    <div>
        <button type="submit" class="btn btn-primary" wire:click="save">
            <i class="fas fa-file-download"></i> Guardar
        </button>
    </div>


    
    <script>
        Dropzone.options.myAwesomeDropzone = {
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    dictDefaultMessage: "Arrastre una imagen al recuadro",
                    acceptedFiles: 'image/*',
                    paramName: "file", // The name that will be used to transfer the file
                    maxFilesize: 2, // MB
                    complete: function(file) {
                        this.removeFile(file);
                    },
                    queuecomplete: function() {
                        Livewire.emit('refreshProduct');
                    }
                };
    </script>

</div>
