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
        Schema::table('banners', function (Blueprint $table) {
            $table->string('catalogue')->nullable();
            $table->string('catalogue_link')->nullable();
            $table->string('about')->nullable();
            $table->string('about_link')->nullable();
            $table->text('text_2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn([
                'catalogue',
                'catalogue_link',
                'about',
                'about_link',
                'text_2',
            ]);
        });
    }
};
