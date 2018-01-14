<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->unsignedInteger('companies_id');
            $table->foreign('companies_id')->references('id')->on('companies');
            $table->unsignedInteger('deals_id');
            $table->foreign('deals_id')->references('id')->on('deals');
            $table->integer('cost');
            $table->dateTime('start_date');
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
        Schema::dropIfExists('projects');
    }
}
