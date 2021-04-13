<?php

namespace Database\Seeders;

use App\Models\Editorial;
use App\Models\Presale;
use Illuminate\Database\Seeder;

class PresaleSeeder extends Seeder
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
                Presale::factory()->count($amount)->for($editorials)->create();
            }
        }
    }
}
