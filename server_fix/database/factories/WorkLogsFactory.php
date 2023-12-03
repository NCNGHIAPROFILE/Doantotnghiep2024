<?php

namespace Database\Factories;

use App\Models\WorkLogs;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use DateTime;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class WorkLogsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = WorkLogs::class;

    public function definition()
    {
        $random = \Carbon\Carbon::now()->subMinutes(rand(1, 55));
        return [
            'user_id' => rand(1, 25),
            'date_time' => $random
        ];
    }

}
