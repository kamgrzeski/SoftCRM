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
            $table->string('city', 255);
            $table->string('billing_address', 255);
            $table->string('state', 255);
            $table->string('country', 255);
            $table->integer('postal_code');
            $table->string('employees', 255);
            $table->integer('fax');
            $table->string('description', 255);
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
        Schema::dropIfExists('companies');
    }
}