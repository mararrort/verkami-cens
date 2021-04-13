<?php

namespace Tests\Browser;

use App\Models\Editorial;
use App\Models\Presale;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PresaleTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testSee()
    {
        $this->browse(function (Browser $browser) {
            $editorial = Editorial::factory()->create();
            $presale = Presale::factory()->for($editorial)->create();

            $browser->visitRoute('preventas.index');
            $browser->assertRouteIs('preventas.index');
            $browser->assertSeeLink($presale->name);
        });
    }

    public function testThereIsNoCodeColour()
    {
        $this->browse(function (Browser $browser) {
            $editorial = Editorial::factory()->create();
            $presale = Presale::factory()->for($editorial)->state([
                'state' => 'Sin definir',
                'late' => false,
            ])->create();

            $browser->visitRoute('preventas.index');
            $browser->assertNotPresent('@danger');
            $browser->assertNotPresent('@success');
        });
    }

    public function testThereIsDangerCodeColour()
    {
        $this->browse(function (Browser $browser) {
            $editorial = Editorial::factory()->create();
            $presale = Presale::factory()->for($editorial)->state([
                'late' => true,
            ])->create();

            $browser->visitRoute('preventas.index');
            $browser->assertPresent('@danger');
        });
    }

    public function testThereIsSuccessCodeColour()
    {
        $this->browse(function (Browser $browser) {
            $editorial = Editorial::factory()->create();
            $presale = Presale::factory()->for($editorial)->state([
                'late' => false,
                'state' => 'Entregado',
            ])->create();

            $browser->visitRoute('preventas.index');
            $browser->assertPresent('@success');
        });
    }
}
