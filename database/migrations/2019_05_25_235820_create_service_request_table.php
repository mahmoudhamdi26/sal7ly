<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_request', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('desc')->nullable();
            $table->timestamps();
            $table->dateTime("needed_at");
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('job_type_id')->nullable();
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('device_type_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('job_type_id')->references('id')->on('job_type')->onDelete('set null');
            $table->foreign('service_id')->references('id')->on('service')->onDelete('cascade');
            $table->foreign('device_type_id')->references('id')->on('device_type')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_request');
    }
}
