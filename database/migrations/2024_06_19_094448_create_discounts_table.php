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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('region');
            $table->string('distributor');
            $table->string('month');
            $table->string('target_june')->default(0);
            $table->string('balance_incentive')->default(0);
            $table->string('four_budget_promotion')->default(0);
            $table->string('release_back')->default(0);
            $table->string('trending_term')->default(0);
            $table->string('TUB')->default(0);
            $table->string('balance_special')->default(0);
            $table->string('adjusment')->default(0);
            $table->string('total_balance')->default(0);
            $table->string('balance_hero')->default(0);
            $table->string('adjusment_hero')->default(0);
            $table->string('return_allowance')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
