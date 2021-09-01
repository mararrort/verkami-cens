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

        $editorials = \App\Models\Editorial::factory(4)->create();

        foreach ($editorials as $editorial) {
            $amount = rand(1, 8);
            if ($amount > 0) {
                for ($i = 0; $i < $amount; $i++) {
                    $presale = \App\Models\Presale::factory()->for($editorial)->create();
                    if (rand(0, 1)) {
                        \App\Models\Petition::factory()->presale($presale)->create();
                        \App\Models\MPU::factory()->for($presale)->create();
                    }
                }
            }
        }

        \App\Models\TODO::factory(8)->create();
        \App\Models\Petition::factory(8)->create();

        $telegramUser = new \App\Models\TelegramUser();
        $telegramUser->id = 296858799;
        $telegramUser->setAcceptedPetitions(true);
        $telegramUser->setCreatedPetitions(true);
        $telegramUser->save();
    }
}
