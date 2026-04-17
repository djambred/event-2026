<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('scores', 'round')) {
            Schema::table('scores', function (Blueprint $table) {
                $table->string('round', 20)->default('selection')->after('judging_criteria_id');
            });
        }

        // Use raw SQL to handle MariaDB foreign key + unique index constraint
        $indexes = collect(Schema::getIndexes('scores'))->pluck('name')->toArray();
        if (in_array('scores_registration_id_judging_criteria_id_unique', $indexes)) {
            // Must disable FK checks to drop unique index used by FK in MariaDB
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB::statement('ALTER TABLE `scores` DROP INDEX `scores_registration_id_judging_criteria_id_unique`');
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        if (!in_array('scores_registration_id_judging_criteria_id_round_unique', $indexes)) {
            Schema::table('scores', function (Blueprint $table) {
                $table->unique(['registration_id', 'judging_criteria_id', 'round']);
            });
        }

        if (!Schema::hasColumn('registrations', 'grandfinal_score')) {
            Schema::table('registrations', function (Blueprint $table) {
                $table->decimal('grandfinal_score', 5, 2)->nullable()->after('final_score');
                $table->integer('grandfinal_rank')->nullable()->after('grandfinal_score');
            });
        }
    }

    public function down(): void
    {
        Schema::table('scores', function (Blueprint $table) {
            $table->dropUnique(['registration_id', 'judging_criteria_id', 'round']);
            $table->unique(['registration_id', 'judging_criteria_id']);
            $table->dropColumn('round');
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn(['grandfinal_score', 'grandfinal_rank']);
        });
    }
};
