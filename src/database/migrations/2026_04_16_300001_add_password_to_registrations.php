<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('password')->after('email')->default('');
            $table->boolean('password_changed')->after('password')->default(false);
        });

        // Set default password for existing registrations
        DB::table('registrations')->update([
            'password' => Hash::make('ueuevent2026'),
        ]);
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn(['password', 'password_changed']);
        });
    }
};
