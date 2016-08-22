<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetups', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('meetup_id')->unique();
            $table->timestamp('start_time')->nullable();
            $table->string('status', 20);
            $table->string('visibility', 20);
            $table->boolean('online')->default(1);
            $table->string('location_name')->nullable();
            $table->string('location_address')->nullable();
            $table->string('location_phone')->nullable();
            $table->string('location_url')->nullable();
            $table->float('location_lat', 10, 8)->nullable();
            $table->float('location_lng', 10, 8)->nullable();
            $table->string('talk');
            $table->string('speaker')->nullable();
            $table->string('speaker_img')->nullable();
            $table->string('speaker_url')->nullable();
            $table->mediumText('additional_info')->nullable();
            $table->integer('venue_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('meetups');
    }
}
