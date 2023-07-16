<?php

namespace Tests\Feature;

use App\Models\Editorial;
use App\Models\MPU;
use App\Models\Presale;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MPUTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_retrieve_valid_presale()
    {
        Presale::factory()
            ->count(10)
            ->state(new Sequence(
                ['state' => 'Recaudando'], 
                ['state' => 'Entregado'], 
                ['state' => 'Abandonado'], 
                ['state' => 'Entregado, faltan recompensas']))
            ->for(Editorial::factory())
            ->create();

        $this->assertDatabaseCount('pending_update_presales', 0);

        $toDeliverPresales = Presale::factory()
            ->count(10)
            ->state(new Sequence(
                ['state' => 'Pendiente de entrega'], 
                ['state' => 'Parcialmente entregado']))
            ->for(Editorial::factory())
            ->create();

        foreach ($toDeliverPresales as $value) {
            $createdAt = $this->faker->dateTimeBetween('-2 weeks', '-1 day');
            MPU::factory()->state(['created_at' => $createdAt])->for($value)->create();
        }

        $this->assertDatabaseCount('pending_update_presales', 0);

        Presale::factory()
            ->count(10)
            ->state(new Sequence(
                ['state' => 'Pendiente de entrega'], 
                ['state' => 'Parcialmente entregado']))
            ->state(['announced_end' => '2022-01-01'])
            ->for(Editorial::factory())
            ->create();

        $this->assertDatabaseCount('pending_update_presales', 10);
    }
}
