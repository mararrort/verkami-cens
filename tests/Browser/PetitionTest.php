<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use Ramsey\Uuid\Uuid;
use App\Models\SolicitudAdicionPreventa;
use App\Models\Empresa;
use App\Models\Preventa;
use App\Models\User;

class PetitionTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testCreatePresaleAndEditorial()
    {
        $prevCount = SolicitudAdicionPreventa::all()->count();
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('peticion.create');
            $browser->type('presale_name', 'Example');
            $browser->type('presale_url', 'example.org');
            $browser->type('editorial_name', 'Example');
            $browser->type('editorial_url', 'example.org');
            $browser->select('state', 'Recaudando');
            $browser->check('late');
            $browser->press('@submit');
            $browser->assertPathIs('/preventas');
        });
        $postCount = SolicitudAdicionPreventa::all()->count();

        $this->assertEquals($prevCount+1, $postCount);
    }

    public function testCreatePresale() {
        $editorial = $this->createFakeEditorial();
        $prevCount = SolicitudAdicionPreventa::all()->count();
        $this->browse(function (Browser $browser) use ($editorial) {
            $browser->visitRoute('peticion.create');
            $browser->type('presale_name', 'Example');
            $browser->type('presale_url', 'example.org');
            $browser->select('editorial_id', $editorial->id);
            $browser->select('state', 'Recaudando');
            $browser->check('late');
            $browser->press('@submit');
            $browser->assertPathIs('/preventas');
        });
        $postCount = SolicitudAdicionPreventa::all()->count();
        $this->assertEquals($prevCount+1, $postCount);  
    }

    public function testEditPresale() 
    {
        $editorial = $this->createFakeEditorial();
        $presale = $this->createFakePresale($editorial);
        $prevCount = SolicitudAdicionPreventa::all()->count();
        $this->browse(function (Browser $browser) use ($presale) {
            $browser->visitRoute('peticion.create', ['presale' => $presale]);
            $browser->select('state', 'Entregado');
            $browser->check('late');
            $browser->press('@submit');
            $browser->assertPathIs('/preventas');
        });

        $postCount = SolicitudAdicionPreventa::all()->count();
        $this->assertEquals($prevCount+1, $postCount);  
    }

    public function testEditPetitionOfModifyPresale()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $editorial = Empresa::factory()->create();
            $presale = Preventa::factory()->for($editorial)->create();
            $presaleData = Preventa::factory()->for($editorial)->make();
            $petition = SolicitudAdicionPreventa::factory()->presale($presale)->create();

            // Trave to the editor
            $browser->loginAs($user);
            $browser->visitRoute('peticion.index');
            $browser->clickLink($presale->name);
            $browser->clickLink("Editar");

            // Assert information
            $browser->assertRouteIs('peticion.edit', [$petition->id]);
            $browser->assertSelected('state', $presale->state);
            
            if($presale->tarde) {
                $browser->assertChecked('late');
            } else {
                $browser->assertNotChecked('late');
            }

            // Edit information
            $browser->select('state', $presaleData->state);
            if ($presaleData->tarde) {
                $browser->check('late');
            } else {
                $browser->uncheck('late');
            }

            $browser->press("Aceptar");

            // Assert information
            $browser->assertRouteIs('peticion.show', ['peticion' => $petition]);
            
            $petition->refresh();

            $this->assertEquals($presaleData->state, $petition->state);
            $this->assertEquals($presaleData->tarde, $petition->late);
        });
    }

    private function createFakeEditorial() {
        $editorial = new Empresa();
        $editorial->id = UUID::uuid4();
        $editorial->name = "Example";
        $editorial->url = "example.org";
        $editorial->save();
        return $editorial;
    }

    private function createFakePresale(Empresa $editorial) {
        $presale = new Preventa();
        $presale->id = UUID::uuid4();
        $presale->name = "Example.org";
        $presale->empresa_id = $editorial->id;
        $presale->url = "example.org";
        $presale->state = "Recaudando";
        $presale->save();
        return $presale;
    }
}
