<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificate_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('competition_category_id')->nullable()->constrained('competition_categories')->nullOnDelete();
            $table->string('background_image'); // admin uploads the certificate design
            $table->integer('name_x')->default(50); // x position (%) for participant name
            $table->integer('name_y')->default(50); // y position (%) for participant name
            $table->integer('name_font_size')->default(36);
            $table->string('name_color')->default('#000000');
            $table->integer('category_x')->default(50); // x position for category text
            $table->integer('category_y')->default(60);
            $table->integer('category_font_size')->default(24);
            $table->string('category_color')->default('#333333');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificate_templates');
    }
};
