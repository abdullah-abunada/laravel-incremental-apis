<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class LessonTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $lessons = \App\Lesson::pluck('id');
        $tags = \App\Tag::pluck('id');

        foreach (range(1, 30) as $index){

            DB::table('lesson_tag')->insert([
                'lesson_id' => $faker->randomElement($lessons->toArray()),
                'tag_id' => $faker->randomElement($tags->toArray())
            ]);
        }
    }
}
