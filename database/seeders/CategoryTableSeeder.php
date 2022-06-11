<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//Category::factory()->count(5)->create();

        //Create tasks for all new Category created
        Category::factory()->count(5)->create()->each(function ($category){
            $category->Tasks()->saveMany(Task::factory()->count(5)->create())->make();
        });


    }
}
