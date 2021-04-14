<?php

namespace Tests\Feature;

use App\Models\Editorial;
use App\Models\Petition;
use App\Models\Presale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PresaleTest extends TestCase
{
    /**
     * Ensure that isNewNotFinished method works correctly.
     *
     * @return void
     */
    public function test_isNewNotFinished_method_works_as_expected()
    {
        // Create tests editorial and presale
        $editorial = Editorial::factory()->create();
        $presales = Presale::factory(10)->state(['state' => 'Entregado'])
            ->for($editorial)->create();

        // Makes the first presale not finished
        $petition = Petition::factory()->presale($presales[0])
            ->state(['state' => 'Sin definir'])->create();
        $this->assertTrue($petition->isNewNotFinished());

        // Makes it finished
        $petition->state = 'Entregado';
        $petition->save();
        $this->assertFalse($petition->isNewNotFinished());

        // Creates a new unfinished presale
        $petition = Petition::factory()->editorial($editorial)
            ->state(['state' => 'Sin definir'])->create();
        $petition->save();
        $this->assertTrue($petition->isNewNotFinished());

        // The new presale is finished
        $petition->state = 'Entregado';
        $petition->save();
        $this->assertFalse($petition->isNewNotFinished());
    }
}