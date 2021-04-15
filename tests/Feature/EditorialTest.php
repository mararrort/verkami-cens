<?php

namespace Tests\Feature;

use App\Models\Editorial;
use App\Models\Presale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditorialTest extends TestCase
{
    /**
     * Ensure the method getNotFinishedLatePresales works.
     *
     * @return void
     */
    public function test_getNotFinishedLatePresales()
    {
        $editorial = Editorial::factory()->create();

        $this->assertEquals(0, count($editorial->getNotFinishedLatePresales()));

        $presale = Presale::factory()->for($editorial)->finished()->create();

        $this->assertEquals(0, count($editorial->getNotFinishedLatePresales()));

        $presale = Presale::factory()->for($editorial)->unfinished()->notLate()->create();

        $this->assertEquals(0, count($editorial->getNotFinishedLatePresales()));

        $presale = Presale::factory()->for($editorial)->unfinished()->late()->create();

        $this->assertEquals(1, count($editorial->getNotFinishedLatePresales()));
    }
}
