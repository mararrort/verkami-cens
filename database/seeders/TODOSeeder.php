<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TODO;

class TODOSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TODO::factory(9)->create();
    }
}
