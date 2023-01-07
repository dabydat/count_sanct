<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Period;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contribution>
 */
class ContributionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'student_id' => $this->getRandomStudent(),
            'category_id' => $this->getRandomCategory(),
            'period_affected_id' => $this->getRandomPeriod(),
            'period_received_id' => $this->getRandomPeriod(),
            'contribution_date' => $this->faker->date($format = 'd-m-Y', $max = 'now'),
            'amount' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
            'bs_amount' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
            'description' => $this->faker->text($max = 120),
            'created_at' => $this->faker->dateTime()
        ];
    }

    public function getRandomStudent()
    {
        $student = Student::where('status', true)->inRandomOrder()->first();
        if ($student != null)
            $student = $student->id;
        return $student;
    }
    public function getRandomCategory()
    {
        $category = Category::where('status', true)->inRandomOrder()->first();
        if ($category != null)
            $category = $category->id;
        return $category;
    }

    public function getRandomPeriod()
    {
        $period = Period::where('status', true)->inRandomOrder()->first();
        if ($period != null)
            $period = $period->id;
        return $period;
    }
}