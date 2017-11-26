<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SystemLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('systemlogs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('actions');
            $table->dateTime('date');
            $table->string('ip_address');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mailing');
    }
}
