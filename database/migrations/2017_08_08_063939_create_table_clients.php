<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableClients extends Migration
{
    public function up() {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name');
            $table->string('phone');
            $table->string('email', 255);
            $table->text('section');
            $table->text('budget');
            $table->text('location');
            $table->text('zip');
            $table->text('city');
            $table->text('country');
            $table->boolean('is_active')->nullable()->default(1);
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
        Schema::dropIfExists('clients');
    }
}
