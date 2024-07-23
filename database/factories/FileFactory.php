<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\Dataset;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = File::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'path' => $this->faker->filePath(),
            'dataset_id' => $this->faker->randomElement(Dataset::pluck('id')->toArray()),
        ];
    }
}
