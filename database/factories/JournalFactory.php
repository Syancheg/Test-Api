<?php

namespace Database\Factories;

use App\Models\Journal;
use Illuminate\Database\Eloquent\Factories\Factory;

class JournalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Journal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence($nbWords = 4, $variableNbWords = true),
            'title' => $this->faker->sentence($nbWords = 8, $variableNbWords = true),
            'image' => "json.jpeg",
            'release_date' => $this->faker->dateTime($max = 'now', $timezone = null)
        ];
    }
}
