<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'text' => $this->faker->text(),
            'score' => $this->faker->numberBetween(0, 100),
            'published' => $this->faker->boolean(80)
        ];
    }
}
