<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('admins', 'administrators');
        Schema::rename('systemlogs', 'system_logs');
        Schema::rename('deals_terms', 'deal_terms');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('administrators', 'admins');
        Schema::rename('system_logs', 'systemlogs');
        Schema::rename('deal_terms', 'deals_terms');
    }
};
