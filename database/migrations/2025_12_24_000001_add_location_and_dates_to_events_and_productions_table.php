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
        Schema::table('events', function (Blueprint $table) {
            $table->string('location')->nullable()->after('client');
            $table->date('start_date')->nullable()->after('location');
            $table->date('end_date')->nullable()->after('start_date');
        });

        Schema::table('productions', function (Blueprint $table) {
            $table->string('location')->nullable()->after('client');
            $table->date('start_date')->nullable()->after('location');
            $table->date('end_date')->nullable()->after('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['location', 'start_date', 'end_date']);
        });

        Schema::table('productions', function (Blueprint $table) {
            $table->dropColumn(['location', 'start_date', 'end_date']);
        });
    }
};
