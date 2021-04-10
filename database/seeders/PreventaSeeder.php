<?php

namespace Database\Seeders;

use App\Models\Empresa;
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
        $empresas = Empresa::all();

        foreach ($empresas as $empresa) {
            $amount = rand(0, 2);
            if ($amount > 0) {
                Preventa::factory()->count($amount)->for($empresa)->create();
            }
        }
    }
}
