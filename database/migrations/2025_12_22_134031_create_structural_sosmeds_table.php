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
        Schema::create('structural_sosmeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('structural_id')->constrained('structurals')->onDelete('cascade');
            $table->string('nama_sosmed'); // e.g., "Instagram", "LinkedIn", "Twitter"
            $table->string('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('structural_sosmeds');
    }
};
