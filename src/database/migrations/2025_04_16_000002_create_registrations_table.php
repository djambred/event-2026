<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_type'); // national, international
            $table->string('full_name');
            $table->string('email');
            $table->string('whatsapp');
            $table->string('institution');
            $table->foreignId('competition_category_id')->constrained('competition_categories')->cascadeOnDelete();
            $table->string('school_uniform_photo')->nullable();
            $table->string('student_id_document')->nullable();
            $table->string('formal_photo')->nullable();
            $table->string('payment_proof')->nullable();
            $table->string('status')->default('pending'); // pending, confirmed, rejected
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
