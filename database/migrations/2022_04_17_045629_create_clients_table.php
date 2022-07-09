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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_compañia');
            $table->string('nombre');
            $table->string('nombre_corto')->nullable();
            $table->string('rfc')->nullable();
            $table->string('pais');
            $table->string('posicion')->nullable();
            $table->string('pagina_web')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('notas', 500);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
};
