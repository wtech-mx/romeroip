<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up() { Schema::table('users', function (Blueprint $table) {
        $table->unsignedTinyInteger('profile_photo_x')->default(50);
        $table->unsignedTinyInteger('profile_photo_y')->default(50);
        $table->decimal('profile_photo_zoom', 3, 2)->default(1);
    }); }
    public function down() { Schema::table('users', fn (Blueprint $table) => $table->dropColumn(['profile_photo_x', 'profile_photo_y', 'profile_photo_zoom'])); }
};
