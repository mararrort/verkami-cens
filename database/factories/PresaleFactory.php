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
        $state = $this->faker->randomElement(['Recaudando', 'Pendiente de entrega', 'Parcialmente entregado', 'Entregado', 'Sin definir']);

        $hasDates = $this->faker->boolean;

        if ($hasDates) {
            $start = $this->faker->dateTimeBetween('-5 years');
            $announcedEnd = $this->faker->dateTimeBetween($start, '+5 years');
        }

        if ($hasDates && $state == 'Entregado') {
            $end = $this->faker->dateTimeBetween($start, '+5 years');
        }

        $tarde = (isset($end) && isset($announcedEnd) && ($end > $announcedEnd)) ? true : false;

        return [
            'id' => $this->faker->uuid,
            'name' => $this->faker->words(3, true),
            'url' => $this->faker->url,
            'state' => $state,
            'late' => $tarde,
            'start' => $start ?? null,
            'announced_end' => $announcedEnd ?? null,
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
                'state' => $this->faker->randomElement(['Recaudando', 'Pendiente de entrega', 'Parcialmente entregado', 'Sin definir']),
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
                'late' => true
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
                'late' => false
            ];
        });
    }
}
