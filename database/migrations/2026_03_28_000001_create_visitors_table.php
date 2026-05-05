<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel log kunjungan (satu baris = satu page view).
     */
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->uuid('visitor_id')->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            /** Ringkasan opsional dari user agent */
            $table->string('browser', 120)->nullable();
            $table->string('device_type', 50)->nullable();
            $table->text('url');
            $table->string('method', 16);
            $table->text('referer')->nullable();
            $table->timestamp('visited_at')->index();

            $table->index(['visitor_id', 'visited_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
