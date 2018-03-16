<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFinances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->string('category');
            $table->string('type');
            $table->integer('gross');
            $table->integer('net')->nullable()->default(0);
            $table->integer('vat')->nullable()->default(0);
            $table->date('date');
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
        Schema::dropIfExists('finances');
    }
}
