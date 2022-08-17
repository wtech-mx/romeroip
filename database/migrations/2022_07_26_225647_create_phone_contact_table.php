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
        Schema::create('phone_clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_contact');
            $table->foreign('id_contact')
                ->references('id')->on('contact_clients')
                ->inDelete('set null');

            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phone_clients');
    }
};
