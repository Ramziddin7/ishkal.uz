<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class UniversityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'country_id'=> Country::all()->random()->id,
            'categories'=>$this->faker->randomElement(['Bachelor','master','PpD']),
            'contract_file'=>$this->faker->paragraph(),
            'name'=>$this->faker->name(),
            'min_price'=>$this->faker->randomNumber(),
            'min_ielts'=>$this->faker->numberBetween(1,9),
            'city_name'=>$this->faker->name(),
            'image'=>$this->faker->name(),
        ];
    }
}
