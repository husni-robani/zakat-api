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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('amount');
            $table->text('description')->nullable();
            $table->foreignId('donation_types_id')->constrained()->cascadeOnDelete();
            $table->foreignId('donors_id')->constrained()->cascadeOnDelete();
            $table->foreignId('wallets_id')->constrained()->cascadeOnDelete();
            $table->foreignId('good_types_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
