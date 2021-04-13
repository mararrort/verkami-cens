<?php

namespace Database\Seeders;

use App\Models\Editorial;
use App\Models\Preventa;
use Illuminate\Database\Seeder;

class PreventaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $editorials = Editorial::all();

        foreach ($editorials as $editorials) {
            $amount = rand(1, 9);
            if ($amount > 0) {
                Preventa::factory()->count($amount)->for($editorials)->create();
            }
        }
    }
}
