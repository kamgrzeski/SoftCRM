<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('companies_id');
            $table->foreign('companies_id')->references('id')->on('companies');
            $table->unsignedInteger('clients_id');
            $table->foreign('clients_id')->references('id')->on('clients');
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
        Schema::dropIfExists('reports');
    }
}
