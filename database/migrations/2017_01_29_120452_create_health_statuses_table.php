<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->double('weight', 6, 2)->nullable();
            $table->double('height', 6, 2)->nullable();
            $table->double('shoulder_width', 6, 2)->nullable();
            $table->double('chest_circumference', 6, 2)->nullable();
            $table->double('middle_circumference', 6, 2)->nullable();
            $table->double('arm_circumference', 6, 2)->nullable();
            $table->double('hip_circumference', 6, 2)->nullable();
            $table->string('diseases')->default('');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('health_statuses');
    }
}
