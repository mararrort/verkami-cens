<?php

namespace Tests\Browser;

use App\Models\Empresa;
use App\Models\Preventa;
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
            $editorial = Empresa::factory()->create();
            $presale = Preventa::factory()->for($editorial)->create();

            $browser->visitRoute('preventas.index');
            $browser->assertRouteIs('preventas.index');
            $browser->assertSeeLink($presale->name);
        });
    }

    public function testThereIsNoCodeColour()
    {
        $this->browse(function (Browser $browser) {
            $editorial = Empresa::factory()->create();
            $presale = Preventa::factory()->for($editorial)->state([
                'tarde' => false,
            ])->create();

            $browser->visitRoute('preventas.index');
            $browser->assertNotPresent('@danger');
            $browser->assertNotPresent('@success');
        });
    }

    public function testThereIsDangerCodeColour()
    {
        $this->browse(function (Browser $browser) {
            $editorial = Empresa::factory()->create();
            $presale = Preventa::factory()->for($editorial)->state([
                'tarde' => true,
            ])->create();

            $browser->visitRoute('preventas.index');
            $browser->assertPresent('@danger');
        });
    }

    public function testThereIsSuccessCodeColour()
    {
        $this->browse(function (Browser $browser) {
            $editorial = Empresa::factory()->create();
            $presale = Preventa::factory()->for($editorial)->state([
                'tarde' => false,
                'state' => 'Entregado',
            ])->create();

            $browser->visitRoute('preventas.index');
            $browser->assertPresent('@success');
        });
    }

    public function testEdit()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $editorial = Empresa::factory()->create();
            $otherEditorial = Empresa::factory()->create();
            $preventa = Preventa::factory()->for($editorial)->create();

            $newPresaleData = Preventa::factory()->for($otherEditorial)->make();

            $browser->loginAs($user);
            $browser->visitRoute('preventas.index');
            $browser->clickLink('Editar');
            $browser->assertRouteIs('preventas.edit', ['preventa' => $preventa]);

            $browser->assertInputValue('name', $preventa->name);
            $browser->clear('name');
            $browser->type('name', $newPresaleData->name);

            $browser->assertInputValue('url', $preventa->url);
            $browser->clear('url');
            $browser->type('url', $newPresaleData->url);

            $browser->assertSelected('editorial', $preventa->empresa->id);
            $browser->select('editorial', $otherEditorial->id);

            $browser->assertSelected('state', $preventa->state);
            $browser->select('state', $newPresaleData->state);

            if ($preventa->tarde) {
                $browser->assertChecked('tarde');
            } else {
                $browser->assertNotChecked('tarde');
            }

            $browser->press('@edit');
            $browser->assertRouteIs('preventas.index');

            $browser->assertSee($newPresaleData->name);
            $browser->assertSee($otherEditorial->name);

            if ($newPresaleData->tarde) {
                $browser->assertSee('No');
            } else {
                $browser->assertSee('Si');
            }

            $browser->assertSourceHas($newPresaleData->url);
        });
    }
}
