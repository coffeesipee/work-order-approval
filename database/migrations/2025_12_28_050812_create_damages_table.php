<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('damages', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('region_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reported_by')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default('pending');
            $table->timestampsTz();
        });

        Schema::create('damage_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('damage_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('quantity');
            $table->string('unit');
            $table->text('description')->nullable();
            $table->timestampsTz();
        });

        Schema::create('damage_proofs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('damage_id')->constrained()->cascadeOnDelete();
            $table->string('image')->nullable();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damages');
        Schema::dropIfExists('damage_items');
        Schema::dropIfExists('damage_proofs');
    }
};
