<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->title,
            'content'=>$this->faker->text,
            'Category_id'=>Category::all()->random()->id,
            'user_id'=>User::all()->random()->id
        ];
    }
}
