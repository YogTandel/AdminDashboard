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
        Schema::create('releases', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_to');
            $table->string('name');
            $table->enum('type', ['admin', 'distributor', 'agent', 'player']);
            $table->decimal('total_bet', 12, 2);
            $table->decimal('commission_percentage', 5, 2);
            $table->decimal('remaining_balance', 10, 2);
            $table->enum('transfer_role', ['admin'])->default('admin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('releases');
    }
};
