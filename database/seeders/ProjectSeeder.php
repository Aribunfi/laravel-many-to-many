<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use Faker\Generator as Faker;

class ProjectSeeder extends Seeder  {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 50; $i++) {
            $project = new Project;
            $project->title = $faker->firstNameFemale();
            $project->year = $faker->unique()->numberBetween(2009, 2023);
            $project->kind = $faker->randomElement(['graphic', 'web', 'writing']);
            $project->time = $faker->unique()->numberBetween(1, 6);
            $project->description = $faker->paragraph(12);
            $project->save();
    }
}}