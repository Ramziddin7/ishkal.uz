<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\University;
use Illuminate\Database\Eloquent\Factories\Factory;

class FieldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'university_id'=>University::all()->random()->id,
            'name'=>$this->faker->name(),
            'category'=>$this->faker->name(),
            'price'=>$this->faker->numberBetween(1000,20000),
            'duration'=>$this->faker->numberBetween(1,4),
            'description'=>$this->faker->paragraph(4),
        ];
    }
}
