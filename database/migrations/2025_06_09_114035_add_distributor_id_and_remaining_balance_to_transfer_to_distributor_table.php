<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transfer_to_distributor', function (Blueprint $table) {
            $table->unsignedBigInteger('distributor_id');
            $table->decimal('remaining_balance', 10, 2);

            // Optional foreign key if you use SQL-style relations
            // $table->foreign('distributor_id')->references('id')->on('distributors')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('transfer_to_distributor', function (Blueprint $table) {
            $table->dropColumn(['distributor_id', 'remaining_balance']);
        });
    }
};
