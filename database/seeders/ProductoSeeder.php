<?php

namespace Database\Seeders;

use App\Models\Imagen;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $productos= [
        [
          'nombre' => 'General',
          'cod_barra' => '1111111111',
          'estado' => 'Habilitado',
          'cantidad' => '1',
          'presentacion' => 'Unidad',
          'stock_minimo' => '1',
          'vencimiento' => 'No',
          'tipo_garantia' => 'NA',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'producto 1',
          'cod_barra' => '111111111120',
          'estado' => 'Habilitado',
          'cantidad' => '50',
          'presentacion' => 'Unidad',
          'stock_minimo' => '15',
          'vencimiento' => 'No',
          'tipo_garantia' => 'N/A',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'producto 2',
          'cod_barra' => '111111111121',
          'estado' => 'Habilitado',
          'cantidad' => '50',
          'presentacion' => 'Unidad',
          'stock_minimo' => '15',
          'vencimiento' => 'No',
          'tipo_garantia' => 'N/A',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'producto 3',
          'cod_barra' => '111111111122',
          'estado' => 'Habilitado',
          'cantidad' => '50',
          'presentacion' => 'Unidad',
          'stock_minimo' => '15',
          'vencimiento' => 'No',
          'tipo_garantia' => 'N/A',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'producto 4',
          'cod_barra' => '111111111123',
          'estado' => 'Habilitado',
          'cantidad' => '50',
          'presentacion' => 'Unidad',
          'stock_minimo' => '15',
          'vencimiento' => 'No',
          'tipo_garantia' => 'N/A',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'producto 5',
          'cod_barra' => '111111111124',
          'estado' => 'Habilitado',
          'cantidad' => '50',
          'presentacion' => 'Unidad',
          'stock_minimo' => '15',
          'vencimiento' => 'No',
          'tipo_garantia' => 'N/A',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'producto 6',
          'cod_barra' => '111111111125',
          'estado' => 'Habilitado',
          'cantidad' => '50',
          'presentacion' => 'Unidad',
          'stock_minimo' => '15',
          'vencimiento' => 'No',
          'tipo_garantia' => 'N/A',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'producto 7',
          'cod_barra' => '111111111126',
          'estado' => 'Habilitado',
          'cantidad' => '50',
          'presentacion' => 'Unidad',
          'stock_minimo' => '15',
          'vencimiento' => 'No',
          'tipo_garantia' => 'N/A',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'producto 8',
          'cod_barra' => '111111111127',
          'estado' => 'Habilitado',
          'cantidad' => '50',
          'presentacion' => 'Unidad',
          'stock_minimo' => '15',
          'vencimiento' => 'No',
          'tipo_garantia' => 'N/A',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'producto 9',
          'cod_barra' => '111111111128',
          'estado' => 'Habilitado',
          'cantidad' => '50',
          'presentacion' => 'Unidad',
          'stock_minimo' => '15',
          'vencimiento' => 'No',
          'tipo_garantia' => 'N/A',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'producto 10',
          'cod_barra' => '111111111129',
          'estado' => 'Habilitado',
          'cantidad' => '50',
          'presentacion' => 'Unidad',
          'stock_minimo' => '15',
          'vencimiento' => 'No',
          'tipo_garantia' => 'N/A',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'producto 11',
          'cod_barra' => '111111111130',
          'estado' => 'Habilitado',
          'cantidad' => '50',
          'presentacion' => 'Unidad',
          'stock_minimo' => '15',
          'vencimiento' => 'No',
          'tipo_garantia' => 'N/A',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'producto 12',
          'cod_barra' => '111111111131',
          'estado' => 'Habilitado',
          'cantidad' => '50',
          'presentacion' => 'Unidad',
          'stock_minimo' => '15',
          'vencimiento' => 'No',
          'tipo_garantia' => 'N/A',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'producto 13',
          'cod_barra' => '111111111132',
          'estado' => 'Habilitado',
          'cantidad' => '50',
          'presentacion' => 'Unidad',
          'stock_minimo' => '15',
          'vencimiento' => 'No',
          'tipo_garantia' => 'N/A',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'producto 14',
          'cod_barra' => '111111111133',
          'estado' => 'Habilitado',
          'cantidad' => '50',
          'presentacion' => 'Unidad',
          'stock_minimo' => '15',
          'vencimiento' => 'No',
          'tipo_garantia' => 'N/A',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'producto 15',
          'cod_barra' => '111111111134',
          'estado' => 'Habilitado',
          'cantidad' => '50',
          'presentacion' => 'Unidad',
          'stock_minimo' => '15',
          'vencimiento' => 'No',
          'tipo_garantia' => 'N/A',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'producto 16',
          'cod_barra' => '111111111135',
          'estado' => 'Habilitado',
          'cantidad' => '50',
          'presentacion' => 'Unidad',
          'stock_minimo' => '15',
          'vencimiento' => 'No',
          'tipo_garantia' => 'N/A',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'producto 17',
          'cod_barra' => '111111111136',
          'estado' => 'Habilitado',
          'cantidad' => '50',
          'presentacion' => 'Unidad',
          'stock_minimo' => '15',
          'vencimiento' => 'No',
          'tipo_garantia' => 'N/A',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'producto 18',
          'cod_barra' => '111111111137',
          'estado' => 'Habilitado',
          'cantidad' => '50',
          'presentacion' => 'Unidad',
          'stock_minimo' => '15',
          'vencimiento' => 'No',
          'tipo_garantia' => 'N/A',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'producto 19',
          'cod_barra' => '111111111138',
          'estado' => 'Habilitado',
          'cantidad' => '50',
          'presentacion' => 'Unidad',
          'stock_minimo' => '15',
          'vencimiento' => 'No',
          'tipo_garantia' => 'N/A',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'producto 20',
          'cod_barra' => '111111111139',
          'estado' => 'Habilitado',
          'cantidad' => '50',
          'presentacion' => 'Unidad',
          'stock_minimo' => '15',
          'vencimiento' => 'No',
          'tipo_garantia' => 'N/A',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
        [
          'nombre' => 'General',
          'cod_barra' => '1111111111',
          'estado' => 'Habilitado',
          'cantidad' => '1',
          'presentacion' => 'Unidad',
          'stock_minimo' => '1',
          'vencimiento' => 'No',
          'tipo_garantia' => 'NA',
          'categoria_id' => '1',
          'modelo_id' => '1',
          'marca_id' => '1',
        ],
      ];

      foreach ($productos as $producto){
        Producto::create($producto);
     }

    }
}
