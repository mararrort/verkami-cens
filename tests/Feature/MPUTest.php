<?php

namespace Tests\Feature;

use App\Models\Editorial;
use App\Models\MPU;
use App\Models\Presale;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MPUTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_retrieve_valid_presale()
    {
        // Creates the material
        $editorial = Editorial::factory()->create();
        $presales = Presale::factory(8)
            ->for($editorial)
            ->create();
        foreach ($presales as $presale) {
            if ($this->faker->boolean()) {
                MPU::factory()
                    ->for($presale)
                    ->create();
            }
        }

        Presale::factory()
            ->for($editorial)
            ->unfinished()
            ->state(['updated_at' => $this->faker->dateTimeBetween('-1 year', '-2 weeks')])
            ->create();

        $presale = \App\Console\Kernel::getPresale();

        $this->assertNotNull($presale);

        $this->assertNotEquals($presale->state, 'Entregado');
        $date = Carbon::now()->subWeek();
        foreach ($presale->MPUs() as $MPU) {
            $this->assertLessThan($date, $MPU->updated_at);
        }
    }
}
