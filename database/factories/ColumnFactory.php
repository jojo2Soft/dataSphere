<?php

namespace Database\Factories;

use App\Models\Column;
use App\Models\Dataset;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Column>
 */
class ColumnFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Column::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'type' => $this->faker->randomElement(['integer', 'string', 'boolean', 'float']),
           'dataset_id' => $this->faker->randomElement(Dataset::pluck('id')->toArray()),
           
        ];
    }
}
