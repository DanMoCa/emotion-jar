<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    protected $tags = [
        'music',
        'activity',
        'indulgent',
        'phrases',
        'videogame'
    ];

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'content' => $this->faker->realText(),
            'tags' => $this->faker->randomElements($this->tags,2)
        ];
    }
}
