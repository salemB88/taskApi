<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    Task::factory()->count(10)->create();
    }
}
