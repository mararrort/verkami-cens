<?php

namespace Tests\Feature;

use App\Models\Editorial;
use App\Models\Petition;
use App\Models\Presale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PetitionTest extends TestCase
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
        $presales = Presale::factory(10)
            ->state(['state' => 'Entregado'])
            ->for($editorial)
            ->create();

        // Makes the first presale not finished
        $petition = Petition::factory()
            ->presale($presales[0])
            ->state(['state' => 'Sin definir'])
            ->create();
        $this->assertTrue($petition->isNewNotFinished());

        // Makes it finished
        $petition->state = 'Entregado';
        $petition->save();
        $this->assertFalse($petition->isNewNotFinished());

        // Creates a new unfinished presale
        $petition = Petition::factory()
            ->editorial($editorial)
            ->state(['state' => 'Sin definir'])
            ->create();
        $petition->save();
        $this->assertTrue($petition->isNewNotFinished());

        // The new presale is finished
        $petition->state = 'Entregado';
        $petition->save();
        $this->assertFalse($petition->isNewNotFinished());
    }

    /**
     * Test the method isNewLate.
     *
     * @return void
     **/
    public function test_isNewLate_method_works_as_expected()
    {
        $editorial = Editorial::factory()->create();
        $presale = Presale::factory()
            ->notLate()
            ->for($editorial)
            ->create();
        $petition = Petition::factory()
            ->presale($presale)
            ->notLate()
            ->create();

        $this->assertFalse($petition->isNewLate());

        $petition->announced_end = '2020-01-01';
        $petition->end = '2021-01-01';

        $this->assertTrue($petition->isNewLate());

        $presale = Presale::factory()
            ->late()
            ->for($editorial)
            ->create();
        $petition = Petition::factory()
            ->presale($presale)
            ->notLate()
            ->create();

        $this->assertFalse($petition->isNewLate());

        $petition->announced_end = '2020-01-01';
        $petition->end = '2021-01-01';

        $this->assertFalse($petition->isNewLate());
    }

    public function test_send_notifications_correctly()
    {
        $editorial = Editorial::factory()->create();
        $startedPresale = Presale::factory()->for($editorial)->state(['state' => "Recaudando"])->create();

        $petition = Petition::factory()->presale($startedPresale)->state(['state' => "Pendiente de entrega"])->create();
        $this->assertTrue($petition->isNotificable());

        $petition = Petition::factory()->editorial($editorial)->state(['state' => "Pendiente de entrega"])->create();
        $this->assertTrue($petition->isNotificable());
    }    
}
