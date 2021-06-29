<?php

namespace Database\Factories;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=> $this->faker->firstName(),
            'price' => $this->faker->randomFloat(2,1,200),
            'quantity' => $this->faker->randomDigit(),
            'updated_at' => Carbon::now('utc')->toDateTimeString(),
            'created_at' => Carbon::now('utc')->toDateTimeString()
        ];
    }
}
