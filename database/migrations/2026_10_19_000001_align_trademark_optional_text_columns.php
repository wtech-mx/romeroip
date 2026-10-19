<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Older installations used DATE or a required column for this optional text.
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE `trademark` MODIFY `designated_countries` VARCHAR(255) NULL');
            foreach (['translation', 'transliteration_trademark', 'disclaimer', 'description_trademark'] as $column) {
                DB::statement("ALTER TABLE `trademark` MODIFY `$column` TEXT NULL");
            }
        }
    }

    public function down()
    {
        // Keep the expanded text capacity so rollback cannot truncate saved content.
    }
};
