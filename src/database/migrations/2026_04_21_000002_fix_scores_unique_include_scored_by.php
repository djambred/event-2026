<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $indexes = collect(Schema::getIndexes('scores'))->pluck('name')->toArray();

        // Drop the old unique that only covers (registration_id, judging_criteria_id, round)
        // This was preventing multiple jury members from each having their own score row.
        if (in_array('scores_registration_id_judging_criteria_id_round_unique', $indexes)) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB::statement('ALTER TABLE `scores` DROP INDEX `scores_registration_id_judging_criteria_id_round_unique`');
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        // Add new unique that includes scored_by so each jury member can have their own score
        // per (registration, criteria, round) combination.
        if (! in_array('scores_reg_criteria_round_jury_unique', $indexes)) {
            DB::statement(
                'ALTER TABLE `scores` ADD UNIQUE `scores_reg_criteria_round_jury_unique` (`registration_id`, `judging_criteria_id`, `round`, `scored_by`)'
            );
        }
    }

    public function down(): void
    {
        $indexes = collect(Schema::getIndexes('scores'))->pluck('name')->toArray();

        if (in_array('scores_reg_criteria_round_jury_unique', $indexes)) {
            DB::statement('ALTER TABLE `scores` DROP INDEX `scores_reg_criteria_round_jury_unique`');
        }

        if (! in_array('scores_registration_id_judging_criteria_id_round_unique', $indexes)) {
            DB::statement(
                'ALTER TABLE `scores` ADD UNIQUE `scores_registration_id_judging_criteria_id_round_unique` (`registration_id`, `judging_criteria_id`, `round`)'
            );
        }
    }
};
