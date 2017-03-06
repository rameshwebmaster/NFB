<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_entries', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('quantity');
            $table->integer('post_id')->unsigned()->nullable();
            $table->integer('section_id')->unsigned();
            $table->string('day');
            $table->integer('week');
            $table->timestamps();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('program_sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_entries');
    }
}
