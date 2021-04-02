<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empresa;
use App\Models\Preventa;

class PreventaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $empresas = Empresa::all();

        foreach ($empresas as $empresa) {
            $amount = rand(0,2);
            if ($amount > 0) {
                Preventa::factory()->count($amount)->for($empresa)->create();
            }
        }
    }
}
