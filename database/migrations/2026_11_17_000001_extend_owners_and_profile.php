<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up() {
        Schema::table('holder', function (Blueprint $table) {
            $table->string('owner_type', 20)->default('Company');
            $table->string('rfc', 30)->nullable(); $table->string('curp', 30)->nullable();
            $table->string('sex', 30)->nullable(); $table->date('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('telephone', 60)->nullable(); $table->string('extension', 20)->nullable();
            $table->string('mobile', 60)->nullable(); $table->string('email')->nullable();
        });
        Schema::table('users', fn (Blueprint $table) => $table->string('job_title')->nullable());
    }
    public function down() {
        Schema::table('users', fn (Blueprint $table) => $table->dropColumn('job_title'));
        Schema::table('holder', fn (Blueprint $table) => $table->dropColumn(['owner_type','rfc','curp','sex','date_of_birth','place_of_birth','telephone','extension','mobile','email']));
    }
};
