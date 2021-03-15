<?php

namespace Database\Seeders;

use App\Models\Seller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lang = 33.7490;
        $long = -84.3880;
        $user1 =Seller::create([
            'name' => 'test',
            'email' => 'test@test.com',
            'phone' => '0560599552',
            'password' => Hash::make(123456),
            'latitude' =>  $lang,
            'longitude'=>   $long,
            'email_verified_at' => now(),
        ]);
        Seller::factory(100)->create();
    }
}
