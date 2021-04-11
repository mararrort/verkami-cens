<?php

namespace Database\Factories;

use App\Models\Preventa;
use Illuminate\Database\Eloquent\Factories\Factory;

class PreventaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Preventa::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $state = $this->faker->randomElement(['Recaudando', 'Pendiente de entrega', 'Parcialmente entregado', 'Entregado', 'Sin definir']);
        $tarde = ($state == 'Recaudando' || $state == 'Sin definir') ? false : $this->faker->boolean;

        return [
            'id' => $this->faker->uuid,
            'name' => $this->faker->words(3, true),
            'url' => $this->faker->url,
            'state' => $state,
            'tarde' => $tarde,
        ];
    }
}
