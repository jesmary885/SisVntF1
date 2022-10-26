<?php

namespace App\Http\Livewire\Productos;

use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductoExport;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Producto;
use App\Models\Producto_sucursal;
use Illuminate\Support\Facades\DB;
use App\Models\Producto_sucursal as Pivot;
use App\Models\ProductoSerialSucursal;
use Illuminate\Database\Eloquent\Builder;


class ProductosExport extends Component
{
    use WithFileUploads;

    public $fecha_actual, $sucursal_nombre, $estado, $sucursales, $vista;
    public $sucursal_id = "";
    public $limitacion_sucursal = true;
    public $isopen = false;

    protected $rules = [
        'estado' => 'required',
        'sucursal_id' => 'required',
    ];

    public function mount(){
        // $usuario_auth = Auth::id();
         $usuario_au = User::where('id',Auth::id())->first();
         if($usuario_au->limitacion == '1'){
             $this->sucursales=Sucursal::all();
         }else{
             $this->limitacion_sucursal = false;
             $this->sucursal_id = $usuario_au->sucursal_id;
             $sucursal_usuario = Sucursal::where('id',$this->sucursal_id)->first();
             $this->sucursal_nombre = $sucursal_usuario->nombre;
         }

     }

    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false;  
    }

    public function render()
    {
        return view('livewire.productos.productos-export');
    }

    public function export(){

        $rules = $this->rules;
        $this->validate($rules);
        $vista = $this->vista;
        //SI SON TODOS LOS ESTADOS Y TODAS LAS SUCUSALES
        if($this->estado == 1){
            if($this->sucursal_id == 0){
                    $productos_sucursal = DB::select('SELECT p.nombre, p.cod_barra,p.categoria_id,p.marca_id,p.modelo_id,p.categoria_id, p.modelo_id, p.marca_id, mc.nombre as marca_nombre, md.nombre as modelo_nombre, c.nombre as categoria_nombre, sum(ps.cantidad) as quantity from productos p 
                    right join categorias c on p.categoria_id = c.id
                    right join modelos md on p.modelo_id = md.id
                    right join marcas mc on p.marca_id = mc.id
                    inner join producto_sucursal ps on p.id = ps.producto_id
                    group by p.nombre, p.cod_barra, p.categoria_id, p.modelo_id, p.marca_id, c.nombre, md.nombre, mc.nombre');

                    $data=json_encode($productos_sucursal);
                    $array = json_decode($data, true);
                    $relacion = 'sql';
                    $sucursal = 0;
            }
            else{//SI SON TODOS LOS ESTADOS Y UNA SUCURSAL EN PARTICULAR
                  $productos_sucursal = Producto::whereHas('sucursals',function(Builder $query) {
                    $query->where('sucursal_id',$this->sucursal_id);
                })->get();
                
                    $array = $productos_sucursal;
                    $relacion ='eloquent';
                    $sucursal = $this->sucursal_id;
            }
        }
        else{
            

            if($this->sucursal_id == 0){//TODAS LAS SUCURSALES PERO UN ESTADO EN PARTICULAR
               
                    if($this->estado == 2) $estado = 1;
                    elseif($this->estado == 3) $estado = 2;
                    $productos_sucursal = DB::select('SELECT p.nombre, p.cod_barra,p.categoria_id,p.marca_id,p.modelo_id,p.categoria_id,p.marca_id,p.modelo_id,p.categoria_id, p.modelo_id, p.marca_id, mc.nombre as marca_nombre, md.nombre as modelo_nombre, c.nombre as categoria_nombre, sum(ps.cantidad) as quantity from productos p 
                    right join categorias c on p.categoria_id = c.id
                    right join modelos md on p.modelo_id = md.id
                    right join marcas mc on p.marca_id = mc.id
                    inner join producto_sucursal ps on p.id = ps.producto_id where p.estado = :estado
                    group by p.nombre, p.cod_barra,p.categoria_id,p.marca_id,p.modelo_id, c.nombre, md.nombre, mc.nombre',array('estado' => $estado));
                    $data=json_encode($productos_sucursal);
                    $array = json_decode($data, true);
                    $relacion = 'sql';
                    $sucursal = 0;
            }

            else{//UNA SUCURSAL EN PARTICULAR Y UN ESTADO EN PARTICULAR
               
                    if($this->estado == 2) $estado = 1;
                    elseif($this->estado == 3) $estado = 2;
                    $productos_sucursal = Producto::where('estado',$estado)
                                                ->whereHas('sucursals',function(Builder $query) {
                                                    $query->where('sucursal_id',$this->sucursal_id);
                                                })->get();

                    $array = $productos_sucursal;
                    $relacion ='eloquent';
                    $sucursal = $this->sucursal_id;
            }
        }
        $this->reset(['isopen','estado','sucursal_id']);
        return Excel::download(new ProductoExport($array,$relacion,$sucursal,$vista), 'ReporteProductos.xlsx');

    }
}
