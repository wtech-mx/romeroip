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
        Schema::create('adress_clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_clients');
            $table->foreign('id_clients')
                ->references('id')->on('clients')
                ->inDelete('set null');

            $table->string('address', 200)->nullable();
            $table->string('billing_address', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adress_clients');
    }
};
