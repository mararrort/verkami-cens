<?php

namespace Database\Factories;

use App\Models\Editorial;
use App\Models\Petition;
use App\Models\Presale;
use Illuminate\Database\Eloquent\Factories\Factory;

class PetitionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Petition::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $editorial = Editorial::factory()->make();
        $presale = Presale::factory()->make();

        return [
            'id' => $this->faker->uuid,
            'presale_name' => $presale->name,
            'presale_url' => $presale->url,
            'editorial_name' => $editorial->name,
            'editorial_url' => $editorial->url,
            'state' => $presale->state,
            'late' => $presale->late,
            'start' => $presale->start,
            'announced_end' => $presale->announced_end,
            'end' => $presale->end,
            'sendTelegramNotification' => true
        ];
    }

    public function presale(Presale $presale)
    {
        return $this->state(function (array $attributes) use ($presale) {
            return [
                'presale_name' => null,
                'presale_url' => null,
                'presale_id' => $presale->id,
                'editorial_id' => $presale->editorial->id,
                'editorial_name' => null,
                'editorial_url' => null,
                'info' => $this->faker->paragraph,
            ];
        });
    }

    public function editorial(Editorial $editorial)
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
