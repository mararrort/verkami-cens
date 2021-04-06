<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\Empresa::factory(10)->create();
         $empresas = \App\Models\Empresa::all();

        foreach ($empresas as $empresa) {
            $amount = rand(1,8);
            if ($amount > 0) {
                \App\Models\Preventa::factory()->count($amount)->for($empresa)->create();
            }
        }
    }
}
