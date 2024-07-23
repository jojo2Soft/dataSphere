<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Dataset;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dataset>
 */
class DatasetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Dataset::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'user_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            
        ];
    }
}
