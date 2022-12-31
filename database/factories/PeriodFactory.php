<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Period>
 */
class PeriodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'description' => $this->makePeriod(),
            'created_at' => $this->faker->dateTime()
        ];
    }

    public function makePeriod()
    {
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $year = Carbon::now()->year;
        // Picking a month 
        $pickingMonth = $months[array_rand($months)];
        // Making the period
        $period = $pickingMonth . $year;

        return $period;
    }
}