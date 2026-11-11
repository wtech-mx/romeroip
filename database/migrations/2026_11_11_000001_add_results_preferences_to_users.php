<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up() { Schema::table('users', function (Blueprint $table) {
        $table->json('results_columns')->nullable();
        $table->string('preferred_locale', 2)->nullable();
    }); }
    public function down() { Schema::table('users', fn (Blueprint $table) => $table->dropColumn(['results_columns', 'preferred_locale'])); }
};
