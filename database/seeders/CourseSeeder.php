<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = [
            ['title' => 'Corso 1', 'description' => 'Bla bla bla', 'active' => rand(0, 1)],
            ['title' => 'Corso 2', 'description' => 'Bla bla bla', 'active' => rand(0, 1)],
            ['title' => 'Corso 3', 'description' => 'Bla bla bla', 'active' => rand(0, 1)],
            ['title' => 'Corso 4', 'description' => 'Bla bla bla', 'active' => rand(0, 1)],
            ['title' => 'Corso 5', 'description' => 'Bla bla bla', 'active' => rand(0, 1)],
            ['title' => 'Corso 6', 'description' => 'Bla bla bla', 'active' => rand(0, 1)],
            ['title' => 'Corso 7', 'description' => 'Bla bla bla', 'active' => rand(0, 1)],
            ['title' => 'Corso 8', 'description' => 'Bla bla bla', 'active' => rand(0, 1)],
            ['title' => 'Corso 9', 'description' => 'Bla bla bla', 'active' => rand(0, 1)],
            ['title' => 'Corso 10', 'description' => 'Bla bla bla', 'active' => rand(0, 1)],
        ];

        foreach ($courses as $data) {
            $course = new Course($data);
            $course->save();
        }
    }
}
