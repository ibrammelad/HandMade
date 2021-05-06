<?php

namespace Database\Factories;

use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

class SellerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Seller::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lang = 33.7490;
        $long = -84.3880;
        return [
            'name' => $this->faker->name,
            'photo' => '1.png',
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->numberBetween(200000 , 155555555),
            'latitude'=> $this->faker->latitude($min = ($lang-mt_rand(0,20)), $max = ($lang+mt_rand(0,20))),
            'longitude' =>$this->faker->longitude($min = ($long-mt_rand(0,20)), $max = ($long+mt_rand(0,20))),
            'password' => bcrypt('secret'), // secret
            'available_seller'=>$this->faker->randomElement([0,1]),

            ];
    }
}
