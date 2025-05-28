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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('agent_comission', 5, 2)->default(0.0);
            $table->decimal('distributor_comission', 5, 2)->default(0.00);
            $table->decimal('earning', 12, 2);
            $table->integer('earning_percentage')->default(0);
            $table->boolean('set_to_minimum')->default(false);
            $table->decimal('standing', 10, 2);
            $table->integer('custom_bet')->default(-1);
            $table->string('result', 10);
            $table->array('last_10_data')->nullable();
            $table->string('is_negative_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
