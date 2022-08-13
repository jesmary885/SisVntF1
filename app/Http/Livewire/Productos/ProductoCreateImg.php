<?php

namespace App\Http\Livewire\Productos;

use App\Models\Imagen;
use App\Models\Producto;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ProductoCreateImg extends Component
{

    public $producto;

    protected $listeners = ['refreshProduct' => 'refreshProduct', 'delete' => 'delete', 'render' => 'render'];



    public function mount(Producto $producto){
        $this->producto = $producto;
    }

    public function render()
    {

        $producto = $this->producto;
        return view('livewire.productos.producto-create-img',compact('producto'));
    }

    public function deleteImage(Imagen $image){
        Storage::delete([$image->url]);
        $image->delete();

        $this->producto = $this->producto->fresh();
    }

    public function delete(){

        $images = $this->producto->images;

        foreach ($images as $image) {
            Storage::delete($image->url);
            $image->delete();
        }

        $this->producto->delete();

        // return redirect()->route('admin.index');

    }

    public function refreshProduct(){
        $this->product = $this->product->fresh();
    }

    public function save(){
        $this->emitTo('productos-productos-index','render');
        $this->emit('alert','Producto creado correctamente');
    }

}
