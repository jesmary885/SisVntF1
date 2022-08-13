<?php

namespace Database\Factories;

use App\Models\Imagen;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImagenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    //protected $model = Imagen::class;

    public function definition()
    {
        return [
           // 'url' =>'productos/' . $this->faker->Image('productos', 640, 480, null, false)
        ];
    }
}
