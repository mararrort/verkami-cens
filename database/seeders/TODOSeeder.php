<?php

namespace Database\Seeders;

use App\Models\TODO;
use Illuminate\Database\Seeder;

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
