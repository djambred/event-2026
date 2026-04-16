<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('registrations')->cascadeOnDelete();
            $table->foreignId('judging_criteria_id')->constrained('judging_criterias')->cascadeOnDelete();
            $table->decimal('score', 5, 2)->default(0); // 0-100
            $table->text('notes')->nullable();
            $table->foreignId('scored_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['registration_id', 'judging_criteria_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
