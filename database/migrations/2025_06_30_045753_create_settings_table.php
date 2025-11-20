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
                    $table->string('agent_id')->nullable();
                    $table->index('agent_id');
                    $table->double('agent_comission', 5, 2)->default(0.00);
                    $table->double('distributor_comission', 5, 2)->default(0.00);
                    $table->double('earning', 12, 2);
                    $table->double('earning_percentage')->default(0);
                    $table->boolean('set_to_minimum')->default(false);
                    $table->decimal('standing', 10, 2);
                    $table->decimal('holding', 10, 2);
                    $table->integer('custom_bet')->default(-1);
                    $table->integer('result', 10);
                    $table->json('last_10_data')->nullable();
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
