<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_holder', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_holder');
            $table->foreign('id_holder')
                ->references('id')->on('holder')
                ->inDelete('set null');

            $table->string('address', 200)->nullable();
            $table->string('commercial_address', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address_holder');
    }
};
