<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDeals extends Migration
{
    public function up() {
        Schema::create('deals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('start_time');
            $table->string('end_time');
            $table->unsignedInteger('companies_id');
            $table->foreign('companies_id')->references('id')->on('companies');
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
        Schema::dropIfExists('deals');
    }
}
