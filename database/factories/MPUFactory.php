<?php

namespace Database\Factories;

use App\Models\MPU;
use Illuminate\Database\Eloquent\Factories\Factory;

class MPUFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MPU::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now')
        ];
    }
}
