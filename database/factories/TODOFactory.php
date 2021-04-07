<?php

namespace Database\Factories;

use App\Models\TODO;
use Illuminate\Database\Eloquent\Factories\Factory;

class TODOFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TODO::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'text' => substr($this->faker->sentence,0,64),
            'type' => $this->faker->randomElement(['private', 'public', 'undecided']),
        ];
    }

    public function private()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'private',
            ];
        });
    }

    public function public()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'public',
            ];
        });
    }
}
