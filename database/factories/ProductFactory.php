<?php

namespace Database\Factories;

use App\Models\Product;
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
            'name' => $this->faker->word,
            'description' =>$this->faker->paragraph(1),
            'available' => $this->faker->randomElement([0, 1]),
            'photo' => $this->faker->randomElement(['1.jpg', '2.jpg', '3.jpg']),
            'seller_id' =>$this->faker->numberBetween(1,100),
            'salary' =>$this->faker->numberBetween(50,5000),
            'category_id' => $this->faker->numberBetween(1,100),
            'calories' => $this->faker->numberBetween(10,1000),
            'time_to_Preparation' => $this->faker->numberBetween(1,100),
        ];
    }
}
