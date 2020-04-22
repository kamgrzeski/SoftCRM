<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDealsTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('deals_terms', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('body');
            $table->unsignedInteger('deal_id');
            $table->foreign('deal_id')->references('id')->on('deals');
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deals_terms');
    }
}
