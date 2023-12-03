<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RoleCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            [
                'id_role' => 2,
                'description' => 'MEMBER',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_role' => 1,
                'description' => 'BOSS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];
        DB::table('role_company')->insert($array);
    }
}
