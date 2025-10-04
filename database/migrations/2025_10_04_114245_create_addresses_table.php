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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('address')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('active')->default(true);
            $table->integer('order')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }
};
