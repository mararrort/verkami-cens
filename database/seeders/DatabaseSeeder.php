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
        $user = new \App\Models\User();
        $user->name = "Mar";
        $user->email = "mar@example.org";
        $user->password = password_hash('password', PASSWORD_BCRYPT);
        $user->save();

         \App\Models\Empresa::factory(32)->create();
         $empresas = \App\Models\Empresa::all();

        foreach ($empresas as $empresa) {
            $amount = rand(1,8);
            if ($amount > 0) {
                for ($i = 0; $i < $amount; $i++) {
                    $presale = \App\Models\Preventa::factory()->for($empresa)->create();
                    if (rand(0,1)) {
                        \App\Models\SolicitudAdicionPreventa::factory()->presale($presale)->create();
                    }
                }
            }
        }

        \App\Models\TODO::factory(9)->create();
        \App\Models\SolicitudAdicionPreventa::factory(10)->create();
    }
}
