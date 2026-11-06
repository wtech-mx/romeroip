<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('crm_activities', function (Blueprint $table) {
            $table->id(); $table->string('kind', 10); $table->string('title'); $table->longText('description')->nullable();
            $table->dateTime('starts_at')->nullable(); $table->dateTime('ends_at')->nullable();
            $table->unsignedBigInteger('created_by')->index(); $table->timestamps();
        });
    }
    public function down() { Schema::dropIfExists('crm_activities'); }
};
