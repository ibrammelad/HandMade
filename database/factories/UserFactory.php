<?php

namespace Database\Factories;

use App\Models\User;
use Faker\Provider\ar_JO\Address;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lang = 33.7490;
        $long = -84.3880;
        return[
            'name' => $this->faker->name,
            'photo' => '1.png',
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->numberBetween(200000 , 155555555),
            'latitude'=> $this->faker->latitude($min = ($lang-mt_rand(0,20)), $max = ($lang+mt_rand(0,20))),
            'longitude' =>$this->faker->longitude($min = ($long-mt_rand(0,20)), $max = ($long+mt_rand(0,20))),
            'email_verified_at' => now(),
            'password' => bcrypt('secret'), // secret
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
