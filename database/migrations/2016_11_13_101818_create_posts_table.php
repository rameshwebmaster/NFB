<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
           $table->increments('id');
            $table->string('title');
            $table->text('body')->nullable();
            $table->text('excerpt')->nullable();
            $table->string('format')->default('standard');
            $table->string('type');
            $table->string('status');
            $table->string('access')->default('free');
            $table->integer('author')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('author')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
