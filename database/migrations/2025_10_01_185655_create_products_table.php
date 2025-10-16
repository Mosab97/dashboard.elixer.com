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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories');
            $table->json('name');
            $table->longText('description')->nullable();
            $table->longText('how_to_use')->nullable();
            $table->longText('details')->nullable();
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->double('price', 10, 2)->default(0);
            $table->double('discount', 10, 2)->default(0);
            $table->double('price_after_discount')->default(0);
            $table->double('rate_count')->default(0);
            $table->integer('quantity')->default(0);
            $table->boolean('featured')->default(false);
            $table->boolean('active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
