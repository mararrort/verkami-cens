<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use Ramsey\Uuid\Uuid;
use App\Models\SolicitudAdicionPreventa;
use App\Models\Empresa;
use App\Models\Preventa;

class CreatePetitionTest extends DuskTestCase
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
