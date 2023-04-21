<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectTecnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $project = Project::all();
        $technologies = Technology::all()->pluck('id')->toArray();

        
        foreach($projects as $project) {
$project
->technologies()
->attach($faker->randomElements($technlogies, random_int(0, 3)));

        }
    }
}
