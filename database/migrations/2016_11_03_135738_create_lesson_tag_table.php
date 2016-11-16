<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_tag', function(Blueprint $table){

            $table->increments('id');
            $table->integer('lesson_id')->unsigned();

            $table->foreign('lesson_id')->referance('id')->on('lessons')
                ->onDelete('cascade')->index();

            $table->integer('tag_id')->unsigned();

            $table->foreign('tag_id')->referance('id')->on('tags')
                ->onDelete('cascade')->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lesson_tag');
    }
}
