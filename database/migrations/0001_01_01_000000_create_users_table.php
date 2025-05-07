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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('player');
            $table->bigInteger('DateOfCreation');
            $table->string('agent');
            $table->decimal('balance', 10, 2)->default(0);
            $table->string('distributor');
            $table->json('gameHistory')->default('[]');
            $table->string('password');
            $table->boolean('isupdated')->default(false);
            $table->enum('role', ['admin', 'distributor', 'agent'])->default('agent');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->boolean('login_status')->default(false);
            $table->integer('endpoint')->default(0);
            $table->decimal('winamount', 10, 2)->default(0);
            $table->unsignedBigInteger('distributor_id');
            $table->unsignedBigInteger('agent_id');
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
