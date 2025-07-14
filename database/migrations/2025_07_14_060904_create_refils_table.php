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
        Schema::create('refils', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_by');
            $table->string('transfer_to');
            $table->enum('type', ['admin', 'distributor', 'agent', 'player']);
            $table->decimal('amount', 10, 2);
            $table->decimal('remaining_balance', 10, 2);
            $table->enum('transfer_role', ['admin', 'distributor', 'agent', 'player']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refils');
    }
};
