<?php

namespace Database\Factories;

use App\Models\SolicitudAdicionPreventa;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Preventa;
use App\Models\Empresa;

class SolicitudAdicionPreventaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SolicitudAdicionPreventa::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'presale_name' => $this->faker->words(3, true),
            'presale_url' => $this->faker->URL,
            'editorial_name' => $this->faker->company,
            'editorial_url' => $this->faker->url,
            'state' => $this->faker->randomElement(['Recaudando', 'Pendiente de entrega', 'Parcialmente entregado', 'Entregado', 'Sin definir']),
            'late' => $this->faker->boolean,
        ];
    }

    public function presale(Preventa $preventa) {
        return $this->state(function (array $attributes) use ($preventa) {
            return [
                'presale_name' => null,
                'presale_url' => null,
                'presale_id' => $preventa->id,
                'editorial_id' => $preventa->empresa->id,
                'editorial_name' => null,
                'editorial_url' => null,
                'state' => $preventa->state,
                'late' => $preventa->tarde
            ];
        });
    }

    public function editorial(Empresa $editorial) {
        return $this->state(function (array $attributes) use ($editorial) {
            return [
                'editorial_id' => $editorial->id,
                'editorial_name' => null,
                'editorial_url' => null,
            ];
        });
    }
}
