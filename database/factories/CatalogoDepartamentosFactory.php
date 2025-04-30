<?php

namespace Database\Factories;

use App\Models\CatalogoDepartamentos;
use Illuminate\Database\Eloquent\Factories\Factory;

class CatalogoDepartamentosFactory extends Factory
{
    protected $model = CatalogoDepartamentos::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->word,
            'descripcion' => $this->faker->sentence,
        ];
    }
}