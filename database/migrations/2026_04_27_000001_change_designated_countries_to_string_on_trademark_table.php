<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE `trademark` MODIFY `designated_countries` VARCHAR(255) NULL');
    }

    public function down()
    {
        DB::statement('ALTER TABLE `trademark` MODIFY `designated_countries` DATE NULL');
    }
};
