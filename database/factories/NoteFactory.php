<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Note::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realTextBetween(3, 10),
            'content' => $this->faker->sentence(5),
            'created_at' => $this->faker->dateTimeInInterval('-1 year', '+1 year'),
            'created_by' => User::all()->random()->id
        ];
    }
}
