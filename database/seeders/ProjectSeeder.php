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
        $categories = Category::all()->pluck('id')->toArray();

        for($i = 0; $i < 50; $i++) {

            $category_id = (random_int(0,1)===1) ? $faker->randomElement($categories) : null;

            $project = new Project;
            $project->category_id = $category_id;
            $project->title = $faker->firstNameFemale();
            $project->slug = Str::of($project->title)->slug('-');
            $project->year = $faker->unique()->numberBetween(2009, 2023);
            $project->kind = $faker->randomElement(['graphic', 'web', 'writing']);
            $project->time = $faker->unique()->numberBetween(1, 6);
            $project->description = $faker->paragraph(12);
            $project->is_published = random_int(0,1);
            $project->save();
    }
}}