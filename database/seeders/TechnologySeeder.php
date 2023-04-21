<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $labels = ["HTML", "Vue js", "Javascript", "Adobe suite"];
    
        
        
        foreach($labels as $label){
            $technology = new Technology();
            $technology->label = $label;

            $technology->save();
        }
    }
}
