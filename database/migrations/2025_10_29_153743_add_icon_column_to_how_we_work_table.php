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
        Schema::table('how_we_works', function (Blueprint $table) {
            if (!Schema::hasColumn('how_we_works', 'icon')) {
                $table->string('icon')->after('description')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('how_we_works', function (Blueprint $table) {
            if (Schema::hasColumn('how_we_works', 'icon')) {
                $table->dropColumn('icon');
            }
        });
    }
};
