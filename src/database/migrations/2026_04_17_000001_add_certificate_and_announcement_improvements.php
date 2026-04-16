<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Split certificate_file into participation and winner cert files
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('participation_certificate')->nullable()->after('certificate_file');
            $table->string('winner_certificate')->nullable()->after('participation_certificate');
        });

        // Migrate existing data
        \DB::table('registrations')
            ->whereNotNull('certificate_file')
            ->update(['participation_certificate' => \DB::raw('certificate_file')]);

        // Add rank text position fields to certificate_templates
        Schema::table('certificate_templates', function (Blueprint $table) {
            $table->integer('rank_x')->default(50)->after('category_color');
            $table->integer('rank_y')->default(70)->after('rank_x');
            $table->integer('rank_font_size')->default(28)->after('rank_y');
            $table->string('rank_color')->default('#E8A317')->after('rank_font_size');
        });

        // Create announcements table for winner publishing per category
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition_category_id')
                ->constrained('competition_categories')
                ->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->integer('winners_count')->default(3);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');

        Schema::table('certificate_templates', function (Blueprint $table) {
            $table->dropColumn(['rank_x', 'rank_y', 'rank_font_size', 'rank_color']);
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn(['participation_certificate', 'winner_certificate']);
        });
    }
};
