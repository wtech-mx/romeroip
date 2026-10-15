<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('trademark', 'int_renewal_date')) {
            Schema::table('trademark', function (Blueprint $table) {
                $table->date('int_renewal_date')->nullable();
            });
        }
    }

    public function down()
    {
        Schema::table('trademark', function (Blueprint $table) {
            $table->dropColumn('int_renewal_date');
        });
    }
};
