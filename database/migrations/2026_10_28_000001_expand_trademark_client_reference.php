<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        if (DB::getDriverName() === 'mysql') DB::statement('ALTER TABLE `trademark` MODIFY `client_ref` LONGTEXT NULL');
    }
    public function down()
    {
        // Keep expanded capacity to avoid truncating saved references.
    }
};
