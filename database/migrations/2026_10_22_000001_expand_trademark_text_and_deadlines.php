<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration {
    public function up() {
        foreach (['notes','description_good','translation_good','description_trademark','translation','transliteration_trademark','disclaimer'] as $column) {
            if (DB::getDriverName() === 'mysql') DB::statement("ALTER TABLE `trademark` MODIFY `$column` LONGTEXT NULL");
        }
        foreach (['opposition_deadline','opposition_response_date','closing_arguments_deadline','closing_arguments_date','first_office_action_deadline','second_office_action_deadline','office_action_response','additional_office_action_date','suspension_request_date','suspension_period_end_date'] as $column) {
            if (!Schema::hasColumn('trademark', $column)) Schema::table('trademark', fn (Blueprint $table) => $table->date($column)->nullable());
        }
    }
    public function down() {
        // Retain captured dates and expanded text capacity to avoid losing user content.
    }
};
