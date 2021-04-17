<?php

namespace Database\Factories;

use App\Models\Presale;
use Illuminate\Database\Eloquent\Factories\Factory;

class PresaleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Presale::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $state = $this->faker->randomElement([
            'Recaudando',
            'Pendiente de entrega',
            'Parcialmente entregado',
            'Entregado',
            'Sin definir',
        ]);

        $start = $this->faker->dateTimeBetween('-5 years');
        $announcedEnd = $this->faker->dateTimeBetween($start, '+5 years');

        if ($state == 'Entregado') {
            $end = $this->faker->dateTimeBetween($start, '+5 years');
        }

        return [
            'id' => $this->faker->uuid,
            'name' => $this->faker->words(3, true),
            'url' => $this->faker->url,
            'state' => $state,
            'start' => $start,
            'announced_end' => $announcedEnd,
            'end' => $end ?? null,
        ];
    }

    /**
     * The presale will be finished.
     *
     * @return array
     **/
    public function finished()
    {
        return $this->state(function (array $attributes) {
            return [
                'state' => 'Entregado',
            ];
        });
    }

    /**
     * The presale will be unfinished.
     *
     * @return array
     **/
    public function unfinished()
    {
        return $this->state(function (array $attributes) {
            return [
                'state' => $this->faker->randomElement([
                    'Pendiente de entrega',
                    'Parcialmente entregado',
                    'Sin definir',
                ]),
            ];
        });
    }

    /**
     * The presale will be late.
     *
     * @return array
     **/
    public function late()
    {
        return $this->state(function (array $attributes) {
            return [
                'end' => $this->faker->dateTimeBetween(
                    $attributes['announced_end'],
                    '+5 years',
                ),
            ];
        });
    }

    /**
     * The presale will not be late.
     *
     * @return array
     **/
    public function notLate()
    {
        return $this->state(function (array $attributes) {
            return [
                'end' => $this->faker->dateTimeBetween(
                    '-5 years',
                    $attributes['announced_end'],
                ),
            ];
        });
    }
}
