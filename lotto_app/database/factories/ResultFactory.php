<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Result>
 */
class ResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'external_id' => $this->faker->randomDigit(),
            'draw_date' => $this->faker->date(),
            'numbers' => $this->faker->randomElements(
                range(1, 49),
                6
            ),
        ];
    }
}
