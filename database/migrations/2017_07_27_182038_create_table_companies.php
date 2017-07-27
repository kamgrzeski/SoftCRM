<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCompanies extends Migration
{

    public function up() {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->integer('tax_number');
            $table->string('tags', 255);
            $table->boolean('is_active')->null()->default(1);
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
        Schema::dropIfExists('companies');
    }
}
