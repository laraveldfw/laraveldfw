<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlackPendingInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slack_pending_invites', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('slack_name', 50);
            $table->string('email');
            $table->string('token', 32);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('slack_pending_invites');
    }
}
