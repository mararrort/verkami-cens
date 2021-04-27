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
            $presale = Presale::factory()
                ->for($editorial)
                ->create();

            $browser->visitRoute('presales.index');
            $browser->assertRouteIs('presales.index');
            $browser->assertSeeLink($presale->name);
        });
    }

    public function testThereIsNoCodeColour()
    {
        $this->browse(function (Browser $browser) {
            $editorial = Editorial::factory()->create();
            $presale = Presale::factory()
                ->for($editorial)
                ->state([
                    'state' => 'Recaudando',
                    'announced_end' => null,
                ])
                ->create();

            $browser->visitRoute('presales.index');
            $browser->assertNotPresent('@danger');
            $browser->assertNotPresent('@success');
        });
    }

    public function testThereIsDangerCodeColour()
    {
        $this->browse(function (Browser $browser) {
            $editorial = Editorial::factory()->create();
            $presale = Presale::factory()
                ->for($editorial)
                ->state([
                    'announced_end' => '2020-01-01',
                    'end' => '2021-01-01',
                ])
                ->create();

            $browser->visitRoute('presales.index');
            $browser->assertPresent('@danger');
        });
    }

    public function testThereIsSuccessCodeColour()
    {
        $this->browse(function (Browser $browser) {
            $editorial = Editorial::factory()->create();
            $presale = Presale::factory()
                ->for($editorial)
                ->state([
                    'announced_end' => '2021-01-01',
                    'end' => '2020-01-01',
                    'state' => 'Entregado',
                ])
                ->create();

            $browser->visitRoute('presales.index');
            $browser->assertPresent('@success');
        });
    }
}
