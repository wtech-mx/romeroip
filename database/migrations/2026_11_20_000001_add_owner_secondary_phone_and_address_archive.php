<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up() {
        Schema::table('holder', fn (Blueprint $table) => $table->string('telephone_secondary', 60)->nullable());
        Schema::table('address_holder', fn (Blueprint $table) => $table->timestamp('removed_at')->nullable());
    }
    public function down() {
        Schema::table('address_holder', fn (Blueprint $table) => $table->dropColumn('removed_at'));
        Schema::table('holder', fn (Blueprint $table) => $table->dropColumn('telephone_secondary'));
    }
};
