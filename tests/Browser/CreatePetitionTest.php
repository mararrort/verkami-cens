<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\SolicitudAdicionPreventa;

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
}
