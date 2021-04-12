<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\Preventa;
use App\Models\SolicitudAdicionPreventa;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $editorial = Empresa::factory()->make();
        $presale = Preventa::factory()->make();

        return [
            'id' => $this->faker->uuid,
            'presale_name' => $presale->name,
            'presale_url' => $presale->url,
            'editorial_name' => $editorial->name,
            'editorial_url' => $editorial->url,
            'state' => $presale->state,
            'late' => $presale->tarde,
            'start' => $presale->start,
            'announced_end' => $presale->announced_end,
            'end' => $presale->end,
        ];
    }

    public function presale(Preventa $preventa)
    {
        return $this->state(function (array $attributes) use ($preventa) {
            return [
                'presale_name' => null,
                'presale_url' => null,
                'presale_id' => $preventa->id,
                'editorial_id' => $preventa->empresa->id,
                'editorial_name' => null,
                'editorial_url' => null,
                'info' => $this->faker->paragraph,
            ];
        });
    }

    public function editorial(Empresa $editorial)
    {
        return $this->state(function (array $attributes) use ($editorial) {
            return [
                'editorial_id' => $editorial->id,
                'editorial_name' => null,
                'editorial_url' => null,
            ];
        });
    }
}
