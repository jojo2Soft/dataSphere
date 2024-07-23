<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Rating;
use App\Models\Dataset;
use App\Models\Analysis;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Rating::class;

    public function definition()
    {
        return [
            'score' => $this->faker->numberBetween(0, 5),
           'user_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'analysis_id' => $this->faker->randomElement(Analysis::pluck('id')->toArray()),
            'dataset_id' => $this->faker->randomElement(Dataset::pluck('id')->toArray()),

        ];
    }
}
