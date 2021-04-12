<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        $user->name = 'Mar';
        $user->email = 'mar@example.org';
        $user->password = password_hash('password', PASSWORD_BCRYPT);
        $user->save();

        $empresas = \App\Models\Empresa::factory(4)->create();

        foreach ($empresas as $empresa) {
            $amount = rand(1, 8);
            if ($amount > 0) {
                for ($i = 0; $i < $amount; $i++) {
                    $presale = \App\Models\Preventa::factory()->for($empresa)->create();
                    if (rand(0, 1)) {
                        \App\Models\SolicitudAdicionPreventa::factory()->presale($presale)->create();
                    }
                }
            }
        }

        \App\Models\TODO::factory(8)->create();
        \App\Models\SolicitudAdicionPreventa::factory(8)->create();

        DB::table('telegram_chat')->insert(['id' => 296858799]);
    }
}
