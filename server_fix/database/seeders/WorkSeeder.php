<?php

namespace Database\Seeders;

use App\Models\WorkLogs;
use Illuminate\Database\Seeder;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkLogs::factory()->count(30)->create();
    }
}
