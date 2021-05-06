<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Seller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');


        Category::factory(40)->create();
        $sellers = Seller::all();

        Category::all()->each(function ($categores) use ($sellers){

            $categores->sellers()->attach(
                $sellers->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }

}
