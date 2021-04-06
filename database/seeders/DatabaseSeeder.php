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
