<?php

namespace Tests\Browser;

use App\Models\Editorial;
use App\Models\Preventa;
use App\Models\SolicitudAdicionPreventa;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Ramsey\Uuid\Uuid;
use Tests\DuskTestCase;

class PetitionTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testUsersCanAccessAdditionPetitionCreation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('preventas.index');
            $linkText = 'Puedes solicitar añadir una preventa a través de este enlace';
            $browser->assertSeeLink($linkText);
            $browser->clickLink($linkText);
            $browser->assertRouteIs('peticion.create');
        });
    }

    public function testUsersCanAccessEditionPetitionCreation()
    {
        $this->browse(function (Browser $browser) {
            $editorial = Editorial::factory()->create();
            $presale = Preventa::factory()->for($editorial)->create();

            $browser->visitRoute('preventas.index');
            $browser->assertPresent('@editPresale');
            $browser->click('@editPresale');
            $browser->assertRouteIs('peticion.create', ['presale' => $presale]);
        });
    }

    public function testCreatePresaleAndEditorial()
    {
        $this->browse(function (Browser $browser) {
            $editorial = Editorial::factory()->make();
            $presale = Preventa::factory()->make();
            $browser->visitRoute('peticion.create');
            $browser->type('presale_name', $presale->name);
            $browser->type('presale_url', $presale->url);
            $browser->type('editorial_name', $editorial->name);
            $browser->type('editorial_url', $editorial->url);
            $browser->select('state', $presale->state);
            if ($presale->tarde) {
                $browser->check('late');
            } else {
                $browser->uncheck('late');
            }

            $browser->press('@submit');
            $browser->assertRouteIs('preventas.index');

            $petition = SolicitudAdicionPreventa::all()[0];
            $this->assertEquals($presale->name, $petition->presale_name);
            $this->assertEquals($presale->url, $petition->presale_url);
            $this->assertEquals($editorial->name, $petition->editorial_name);
            $this->assertEquals($editorial->url, $petition->editorial_url);
            $this->assertEquals($presale->state, $petition->state);
            $this->assertEquals($presale->tarde, $petition->late);
        });
    }

    public function testCreatePresale()
    {
        $this->browse(function (Browser $browser) {
            $editorial = Editorial::factory()->create();
            $presale = Preventa::factory()->make();
            $browser->visitRoute('peticion.create');
            $browser->type('presale_name', $presale->name);
            $browser->type('presale_url', $presale->url);
            $browser->select('editorial_id', $editorial->id);
            $browser->select('state', $presale->state);
            if ($presale->tarde) {
                $browser->check('late');
            } else {
                $browser->uncheck('late');
            }
            $browser->press('@submit');
            $browser->assertRouteIs('preventas.index');

            $petition = SolicitudAdicionPreventa::all()[0];
            $this->assertEquals($presale->name, $petition->presale_name);
            $this->assertEquals($presale->url, $petition->presale_url);
            $this->assertEquals($editorial->id, $petition->editorial_id);
            $this->assertEquals($presale->state, $petition->state);
            $this->assertEquals($presale->tarde, $petition->late);
        });
    }

    public function testEditPresale()
    {
        $this->browse(function (Browser $browser) {
            $editorial = Editorial::factory()->create();
            $presale = Preventa::factory()->for($editorial)->create();
            $petitionBase = SolicitudAdicionPreventa::factory()->presale($presale)->make();

            $browser->visitRoute('peticion.create', ['presale' => $presale]);
            $browser->select('state', $petitionBase->state);
            if ($petitionBase->late) {
                $browser->check('late');
            } else {
                $browser->uncheck('late');
            }
            $browser->type('info', $petitionBase->info);

            $browser->press('@submit');
            $browser->assertRouteIs('preventas.index');

            $petition = SolicitudAdicionPreventa::all()[0];
            $this->assertEquals($presale->id, $petition->presale_id);
            $this->assertEquals($editorial->id, $petition->editorial_id);
            $this->assertEquals($petitionBase->state, $petition->state);
            $this->assertEquals($petitionBase->late, $petition->late);
            $this->assertEquals($petitionBase->info, $petition->info);
        });
    }

    public function testAuthCanSeeCreatePresaleAndEditorialPetition()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $petition = SolicitudAdicionPreventa::factory()->create();

            $browser->loginAs($user);
            $browser->visitRoute('peticion.index');
            $browser->assertRouteIs('peticion.index');
            $browser->clickLink($petition->presale_name);
            $browser->assertRouteIs('peticion.show', ['peticion' => $petition]);
            $browser->assertPresent('@header');
        });
    }

    public function testAuthCanSeeCreatePresalePetition()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $editorial = Editorial::factory()->create();
            $petition = SolicitudAdicionPreventa::factory()->editorial($editorial)->create();

            $browser->loginAs($user);
            $browser->visitRoute('peticion.index');
            $browser->assertRouteIs('peticion.index');
            $browser->clickLink($petition->presale_name);
            $browser->assertRouteIs('peticion.show', ['peticion' => $petition]);
            $browser->assertPresent('@header');
        });
    }

    public function testAuthCanSeeEditPetition()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $editorial = Editorial::factory()->create();
            $presale = Preventa::factory()->for($editorial)->create();
            $petition = SolicitudAdicionPreventa::factory()->presale($presale)->create();

            $browser->loginAs($user);
            $browser->visitRoute('peticion.index');
            $browser->assertRouteIs('peticion.index');
            $browser->clickLink($presale->name);
            $browser->assertRouteIs('peticion.show', ['peticion' => $petition]);
            $browser->assertPresent('@header');
        });
    }

    public function testAuthCanAcceptPetition()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $editorial = Editorial::factory()->create();
            $presale = Preventa::factory()->for($editorial)->create();
            $petition = SolicitudAdicionPreventa::factory()->presale($presale)->create();

            $browser->loginAs($user);
            $browser->visitRoute('peticion.show', ['peticion' => $petition]);
            $browser->press('Accept');
            $browser->assertRouteIs('peticion.index');

            $presale->refresh();

            $this->assertEquals($petition->late, $presale->tarde);
        });
    }

    public function testAuthCanDeletePetition()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $editorial = Editorial::factory()->create();
            $presale = Preventa::factory()->for($editorial)->create();
            $petition = SolicitudAdicionPreventa::factory()->presale($presale)->create();

            $browser->loginAs($user);
            $browser->visitRoute('peticion.show', ['peticion' => $petition]);
            $browser->press('Delete');
            $browser->assertRouteIs('peticion.index');

            $this->assertEmpty(SolicitudAdicionPreventa::all());
        });
    }

    public function testEditPetitionOfCreatePresaleAndEditorial()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $editorial = Editorial::factory()->create();
            $presale = Preventa::factory()->for($editorial)->create();
            $correctedEditorial = Editorial::factory()->make();
            $correctedPresale = Preventa::factory()->for($editorial)->make();
            $petition = SolicitudAdicionPreventa::factory()->presale($presale)->create();

            // Travel to the editor
            $browser->loginAs($user);
            $browser->visitRoute('peticion.edit', ['peticion' => $petition]);

            // Assert information
            $browser->assertInputValue('presale_name', $petition->presale_name);
            $browser->assertInputValue('presale_url', $petition->presale_url);
            $browser->assertInputValue('editorial_name', $petition->editorial_name);
            $browser->assertInputValue('editorial_url', $petition->editorial_url);
            $browser->assertSelected('state', $petition->state);

            if ($petition->late) {
                $browser->assertChecked('late');
            } else {
                $browser->assertNotChecked('late');
            }

            // Edit information
            $browser->clear('presale_name');
            $browser->type('presale_name', $correctedPresale->name);
            $browser->clear('presale_url');
            $browser->type('presale_url', $correctedPresale->url);
            $browser->clear('editorial_name');
            $browser->type('editorial_name', $correctedEditorial->name);
            $browser->clear('editorial_url');
            $browser->type('editorial_url', $correctedEditorial->url);
            $browser->select('state', $correctedPresale->state);
            if ($correctedPresale->tarde) {
                $browser->check('late');
            } else {
                $browser->uncheck('late');
            }
            $browser->press('Aceptar');

            // Assert information
            $browser->assertRouteIs('peticion.show', ['peticion' => $petition]);

            $petition->refresh();

            $this->assertEquals($correctedPresale->name, $petition->presale_name);
            $this->assertEquals($correctedPresale->url, $petition->presale_url);
            $this->assertEquals($correctedEditorial->name, $petition->editorial_name);
            $this->assertEquals($correctedEditorial->url, $petition->editorial_url);
            $this->assertEquals($correctedPresale->state, $petition->state);
            $this->assertEquals($correctedPresale->tarde, $petition->late);
        });
    }

    public function testEditPetitionOfCreatePresale()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $editorial = Editorial::factory()->create();
            $presale = Preventa::factory()->for($editorial)->create();
            $otherEditorial = Editorial::factory()->create();
            $correctedPresale = Preventa::factory()->for($editorial)->make();
            $petition = SolicitudAdicionPreventa::factory()->editorial($editorial)->create();

            // Travel to the editor
            $browser->loginAs($user);
            $browser->visitRoute('peticion.edit', ['peticion' => $petition]);

            // Assert information
            $browser->assertInputValue('presale_name', $petition->presale_name);
            $browser->assertInputValue('presale_url', $petition->presale_url);
            $browser->assertSelected('editorial_id', $petition->editorial_id);
            $browser->assertSelected('state', $petition->state);

            if ($petition->late) {
                $browser->assertChecked('late');
            } else {
                $browser->assertNotChecked('late');
            }

            // Edit information
            $browser->clear('presale_name');
            $browser->type('presale_name', $correctedPresale->name);
            $browser->clear('presale_url');
            $browser->type('presale_url', $correctedPresale->url);
            $browser->select('editorial_id', $otherEditorial->id);
            $browser->select('state', $correctedPresale->state);
            if ($correctedPresale->tarde) {
                $browser->check('late');
            } else {
                $browser->uncheck('late');
            }
            $browser->press('Aceptar');

            // Assert information
            $browser->assertRouteIs('peticion.show', ['peticion' => $petition]);

            $petition->refresh();

            $this->assertEquals($correctedPresale->name, $petition->presale_name);
            $this->assertEquals($correctedPresale->url, $petition->presale_url);
            $this->assertEquals($otherEditorial->id, $petition->editorial_id);
            $this->assertEquals($correctedPresale->state, $petition->state);
            $this->assertEquals($correctedPresale->tarde, $petition->late);
        });
    }

    public function testEditPetitionOfModifyPresale()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $editorial = Editorial::factory()->create();
            $presale = Preventa::factory()->for($editorial)->create();
            $petition = SolicitudAdicionPreventa::factory()->presale($presale)->create();

            $newPetition = SolicitudAdicionPreventa::factory()->presale($presale)->make();

            // Travel to the editor
            $browser->loginAs($user);
            $browser->visitRoute('peticion.index');
            $browser->clickLink($presale->name);
            $browser->clickLink('Editar');

            // Assert information
            $browser->assertRouteIs('peticion.edit', [$petition->id]);
            $browser->assertSelected('state', $petition->state);

            if ($petition->late) {
                $browser->assertChecked('late');
            } else {
                $browser->assertNotChecked('late');
            }
            $browser->assertInputValue('info', $petition->info);

            // Edit information
            $browser->select('state', $newPetition->state);
            if ($newPetition->late) {
                $browser->check('late');
            } else {
                $browser->uncheck('late');
            }

            $browser->press('Aceptar');

            // Assert information
            $browser->assertRouteIs('peticion.show', ['peticion' => $petition]);

            $petition->refresh();

            $this->assertEquals($newPetition->state, $petition->state);
            $this->assertEquals($newPetition->late, $petition->late);
        });
    }
}
