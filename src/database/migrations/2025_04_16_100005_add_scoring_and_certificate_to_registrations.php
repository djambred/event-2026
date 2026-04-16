<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('access_token', 64)->unique()->nullable()->after('status');
            $table->decimal('final_score', 5, 2)->nullable()->after('access_token');
            $table->integer('rank')->nullable()->after('final_score');
            $table->string('certificate_file')->nullable()->after('rank');
        });

        // Generate tokens for existing registrations
        foreach (\App\Models\Registration::all() as $reg) {
            $reg->update(['access_token' => Str::random(32)]);
        }
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn(['access_token', 'final_score', 'rank', 'certificate_file']);
        });
    }
};
