<?php

namespace Tests\Feature;

use App\Models\Editorial;
use App\Models\Petition;
use App\Models\Presale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CascadeRemoveTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_remove_editorial()
    {
        // Creates the material
        $editorial = Editorial::factory()->create();
        $presales = Presale::factory(8)->for($editorial)->create();
        foreach ($presales as $presale) {
            Petition::factory()->presale($presale)->create();
        }
        Petition::factory(8)->editorial($editorial)->create();

        // Deletes the editorial
        $editorial->delete();

        // Check there is nothing in the DDBB
        $this->assertEmpty(Editorial::all());
        $this->assertEmpty(Presale::all());
        $this->assertEmpty(Petition::all());
    }
}
