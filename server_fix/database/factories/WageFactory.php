<?php

namespace Database\Factories;

use App\Models\Wage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use DateTime;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class WageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Wage::class;

    public function definition()
    {

        return [
            'basic_salary' => rand(4000000, 999999999999),
            'allowance' => rand(100000, 1000000),
            'bonus' => rand(100000, 1000000),
            'insurance' => rand(100000000000, 999999999999),
            'tax' => '10',
            'salary_date' => new DateTime(),
            'total' => rand(100000000000, 999999999999),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }


}
