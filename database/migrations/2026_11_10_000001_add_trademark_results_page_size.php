<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasColumn('users', 'trademark_results_per_page')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedSmallInteger('trademark_results_per_page')->default(50);
            });
        }
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('trademark_results_per_page');
        });
    }
};
