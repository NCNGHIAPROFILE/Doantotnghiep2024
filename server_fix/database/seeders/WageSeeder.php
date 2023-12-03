<?php

namespace Database\Seeders;

use App\Models\Wage;
use Illuminate\Database\Seeder;

class WageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Wage::factory()->count(30)->create();
    }
}
