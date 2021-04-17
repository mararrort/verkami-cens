<?php

namespace Tests\Browser;

use App\Models\Editorial;
use App\Models\Petition;
use App\Models\Presale;
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
            $browser->visitRoute("preventas.index");
            $linkText =
                "Puedes solicitar añadir una preventa a través de este enlace";
            $browser->assertSeeLink($linkText);
            $browser->clickLink($linkText);
            $browser->assertRouteIs("peticion.create");
        });
    }

    public function testUsersCanAccessEditionPetitionCreation()
    {
        $this->browse(function (Browser $browser) {
            $editorial = Editorial::factory()->create();
            $presale = Presale::factory()
                ->for($editorial)
                ->create();

            $browser->visitRoute("preventas.index");
            $browser->assertPresent("@editPresale");
            $browser->click("@editPresale");
            $browser->assertRouteIs("peticion.create", ["presale" => $presale]);
        });
    }

    public function testCreatePresaleAndEditorial()
    {
        $this->browse(function (Browser $browser) {
            $editorial = Editorial::factory()->make();
            $presale = Presale::factory()->make();
            $browser->visitRoute("peticion.create");
            $browser->type("presale_name", $presale->name);
            $browser->type("presale_url", $presale->url);
            $browser->type("editorial_name", $editorial->name);
            $browser->type("editorial_url", $editorial->url);
            $browser->select("state", $presale->state);

            $browser->press("@submit");
            $browser->assertRouteIs("preventas.index");

            $petition = Petition::all()[0];
            $this->assertEquals($presale->name, $petition->presale_name);
            $this->assertEquals($presale->url, $petition->presale_url);
            $this->assertEquals($editorial->name, $petition->editorial_name);
            $this->assertEquals($editorial->url, $petition->editorial_url);
            $this->assertEquals($presale->state, $petition->state);
        });
    }

    public function testCreatePresale()
    {
        $this->browse(function (Browser $browser) {
            $editorial = Editorial::factory()->create();
            $presale = Presale::factory()->make();
            $browser->visitRoute("peticion.create");
            $browser->type("presale_name", $presale->name);
            $browser->type("presale_url", $presale->url);
            $browser->select("editorial_id", $editorial->id);
            $browser->select("state", $presale->state);
            $browser->press("@submit");
            $browser->assertRouteIs("preventas.index");

            $petition = Petition::all()[0];
            $this->assertEquals($presale->name, $petition->presale_name);
            $this->assertEquals($presale->url, $petition->presale_url);
            $this->assertEquals($editorial->id, $petition->editorial_id);
            $this->assertEquals($presale->state, $petition->state);
        });
    }

    public function testEditPresale()
    {
        $this->browse(function (Browser $browser) {
            $editorial = Editorial::factory()->create();
            $presale = Presale::factory()
                ->for($editorial)
                ->create();
            $petitionBase = Petition::factory()
                ->presale($presale)
                ->make();

            $browser->visitRoute("peticion.create", ["presale" => $presale]);
            $browser->select("state", $petitionBase->state);
            $browser->type("info", $petitionBase->info);

            $browser->press("@submit");
            $browser->assertRouteIs("preventas.index");

            $petition = Petition::all()[0];
            $this->assertEquals($presale->id, $petition->presale_id);
            $this->assertEquals($editorial->id, $petition->editorial_id);
            $this->assertEquals($petitionBase->state, $petition->state);
            $this->assertEquals($petitionBase->info, $petition->info);
        });
    }

    public function testAuthCanSeeCreatePresaleAndEditorialPetition()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $petition = Petition::factory()->create();

            $browser->loginAs($user);
            $browser->visitRoute("peticion.index");
            $browser->assertRouteIs("peticion.index");
            $browser->clickLink($petition->presale_name);
            $browser->assertRouteIs("petition.show", ["petition" => $petition]);
            $browser->assertPresent("@header");
        });
    }

    public function testAuthCanSeeCreatePresalePetition()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $editorial = Editorial::factory()->create();
            $petition = Petition::factory()
                ->editorial($editorial)
                ->create();

            $browser->loginAs($user);
            $browser->visitRoute("peticion.index");
            $browser->assertRouteIs("peticion.index");
            $browser->clickLink($petition->presale_name);
            $browser->assertRouteIs("petition.show", ["petition" => $petition]);
            $browser->assertPresent("@header");
        });
    }

    public function testAuthCanSeeEditPetition()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $editorial = Editorial::factory()->create();
            $presale = Presale::factory()
                ->for($editorial)
                ->create();
            $petition = Petition::factory()
                ->presale($presale)
                ->create();

            $browser->loginAs($user);
            $browser->visitRoute("peticion.index");
            $browser->assertRouteIs("peticion.index");
            $browser->clickLink($presale->name);
            $browser->assertRouteIs("petition.show", ["petition" => $petition]);
            $browser->assertPresent("@header");
        });
    }

    public function testAuthCanAcceptPetition()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $editorial = Editorial::factory()->create();
            $presale = Presale::factory()
                ->for($editorial)
                ->create();
            $petition = Petition::factory()
                ->presale($presale)
                ->create();

            $browser->loginAs($user);
            $browser->visitRoute("petition.show", ["petition" => $petition]);
            $browser->press("Accept");
            $browser->assertRouteIs("peticion.index");
        });
    }

    public function testAuthCanDeletePetition()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $editorial = Editorial::factory()->create();
            $presale = Presale::factory()
                ->for($editorial)
                ->create();
            $petition = Petition::factory()
                ->presale($presale)
                ->create();

            $browser->loginAs($user);
            $browser->visitRoute("petition.show", ["petition" => $petition]);
            $browser->press("Delete");
            $browser->assertRouteIs("peticion.index");

            $this->assertEmpty(Petition::all());
        });
    }

    public function testEditPetitionOfCreatePresaleAndEditorial()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $editorial = Editorial::factory()->create();
            $presale = Presale::factory()
                ->for($editorial)
                ->create();
            $correctedEditorial = Editorial::factory()->make();
            $correctedPresale = Presale::factory()
                ->for($editorial)
                ->make();
            $petition = Petition::factory()
                ->presale($presale)
                ->create();

            // Travel to the editor
            $browser->loginAs($user);
            $browser->visitRoute("peticion.edit", ["peticion" => $petition]);

            // Assert information
            $browser->assertInputValue("presale_name", $petition->presale_name);
            $browser->assertInputValue("presale_url", $petition->presale_url);
            $browser->assertInputValue(
                "editorial_name",
                $petition->editorial_name,
            );
            $browser->assertInputValue(
                "editorial_url",
                $petition->editorial_url,
            );
            $browser->assertSelected("state", $petition->state);

            // Edit information
            $browser->clear("presale_name");
            $browser->type("presale_name", $correctedPresale->name);
            $browser->clear("presale_url");
            $browser->type("presale_url", $correctedPresale->url);
            $browser->clear("editorial_name");
            $browser->type("editorial_name", $correctedEditorial->name);
            $browser->clear("editorial_url");
            $browser->type("editorial_url", $correctedEditorial->url);
            $browser->select("state", $correctedPresale->state);
            $browser->press("Aceptar");

            // Assert information
            $browser->assertRouteIs("petition.show", ["petition" => $petition]);

            $petition->refresh();

            $this->assertEquals(
                $correctedPresale->name,
                $petition->presale_name,
            );
            $this->assertEquals($correctedPresale->url, $petition->presale_url);
            $this->assertEquals(
                $correctedEditorial->name,
                $petition->editorial_name,
            );
            $this->assertEquals(
                $correctedEditorial->url,
                $petition->editorial_url,
            );
            $this->assertEquals($correctedPresale->state, $petition->state);
        });
    }

    public function testEditPetitionOfCreatePresale()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $editorial = Editorial::factory()->create();
            $presale = Presale::factory()
                ->for($editorial)
                ->create();
            $otherEditorial = Editorial::factory()->create();
            $correctedPresale = Presale::factory()
                ->for($editorial)
                ->make();
            $petition = Petition::factory()
                ->editorial($editorial)
                ->create();

            // Travel to the editor
            $browser->loginAs($user);
            $browser->visitRoute("peticion.edit", ["peticion" => $petition]);

            // Assert information
            $browser->assertInputValue("presale_name", $petition->presale_name);
            $browser->assertInputValue("presale_url", $petition->presale_url);
            $browser->assertSelected("editorial_id", $petition->editorial_id);
            $browser->assertSelected("state", $petition->state);

            // Edit information
            $browser->clear("presale_name");
            $browser->type("presale_name", $correctedPresale->name);
            $browser->clear("presale_url");
            $browser->type("presale_url", $correctedPresale->url);
            $browser->select("editorial_id", $otherEditorial->id);
            $browser->select("state", $correctedPresale->state);

            $browser->press("Aceptar");

            // Assert information
            $browser->assertRouteIs("petition.show", ["petition" => $petition]);

            $petition->refresh();

            $this->assertEquals(
                $correctedPresale->name,
                $petition->presale_name,
            );
            $this->assertEquals($correctedPresale->url, $petition->presale_url);
            $this->assertEquals($otherEditorial->id, $petition->editorial_id);
            $this->assertEquals($correctedPresale->state, $petition->state);
        });
    }

    public function testEditPetitionOfModifyPresale()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $editorial = Editorial::factory()->create();
            $presale = Presale::factory()
                ->for($editorial)
                ->create();
            $petition = Petition::factory()
                ->presale($presale)
                ->create();

            $newPetition = Petition::factory()
                ->presale($presale)
                ->make();

            // Travel to the editor
            $browser->loginAs($user);
            $browser->visitRoute("peticion.index");
            $browser->clickLink($presale->name);
            $browser->clickLink("Editar");

            // Assert information
            $browser->assertRouteIs("peticion.edit", [$petition->id]);
            $browser->assertSelected("state", $petition->state);

            $browser->assertInputValue("info", $petition->info);

            // Edit information
            $browser->select("state", $newPetition->state);

            $browser->press("Aceptar");

            // Assert information
            $browser->assertRouteIs("petition.show", ["petition" => $petition]);

            $petition->refresh();

            $this->assertEquals($newPetition->state, $petition->state);
        });
    }

    /**
     * Test that no errors are shown in a valid petition.
     *
     * @return void
     **/
    public function testNotShowErrors(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $editorial = Editorial::factory()->create();
            $presale = Presale::factory()
                ->for($editorial)
                ->create();
            $petition = Petition::factory()->create();

            // Travel to the editor
            $browser->loginAs($user);
            $browser->visitRoute("petition.show", [$petition]);

            $browser->assertMissing("@presaleUrlError");
            $browser->assertMissing("@presaleUrlError");
        });
    }

    /**
     * Test the errors shown when a non valid petition is show.
     *
     * A petition will show errors in this conditions:
     * * The presale url is already in use
     * * The editorial url is already in use
     *
     * @return void
     **/
    public function testShowErrors(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $editorial = Editorial::factory()->create();
            $presale = Presale::factory()
                ->for($editorial)
                ->create();
            $petition = Petition::factory()->create();

            $petition->presale_url = $presale->url;
            $petition->editorial_url = $editorial->url;
            $petition->save();

            $browser->loginAs($user);
            $browser->visitRoute("petition.show", [$petition]);

            $browser->assertVisible("@presaleUrlError");
            $browser->assertVisible("@editorialUrlError");
        });
    }
}
