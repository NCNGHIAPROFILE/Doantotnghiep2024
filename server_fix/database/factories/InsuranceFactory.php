<?php

namespace Database\Factories;

use App\Models\Insurance;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use DateTime;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class InsuranceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Insurance::class;

    public function definition()
    {

        return [
            'start_date' =>  Carbon::now(),
            'percent' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }


}
