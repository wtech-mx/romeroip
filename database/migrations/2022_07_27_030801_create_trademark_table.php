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
        Schema::create('trademark', function (Blueprint $table) {
            $table->id();
            $table->string('client_ref')->nullable();
            $table->string('notes', 500)->nullable();
            $table->string('our_ref')->nullable();
            $table->string('opposition_no')->nullable();
            $table->date('filing_date_opposition')->nullable();
            $table->string('litigation_no')->nullable();
            $table->date('filing_date_litigation')->nullable();

            $table->string('application_no')->nullable();
            $table->string('origin')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('country')->nullable();
            $table->date('filing_date_general')->nullable();
            $table->string('status')->nullable();
            $table->date('first_date')->nullable();
            $table->string('int_registration_no')->nullable();
            $table->date('registration_date')->nullable();
            $table->date('int_registration_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->string('contracting_organization')->nullable();
            $table->date('publication_date')->nullable();
            $table->date('designated_countries')->nullable();

            $table->date('last_declaration')->nullable();
            $table->date('last_renewal')->nullable();
            $table->date('next_declaration')->nullable();
            $table->date('next_renewal')->nullable();

            $table->string('trademark')->nullable();
            $table->string('design', 900)->nullable();
            $table->string('description_trademark', 500)->nullable();
            $table->string('type_application')->nullable();
            $table->string('type_mark')->nullable();
            $table->string('translation', 500)->nullable();
            $table->string('transliteration_trademark', 500)->nullable();
            $table->string('disclaimer', 500)->nullable();

            $table->string('class')->nullable();
            $table->string('translation_good', 500)->nullable();
            $table->string('description_good', 500)->nullable();

            $table->string('priority_no')->nullable();
            $table->string('country_office')->nullable();
            $table->date('priority_date')->nullable();

            $table->unsignedBigInteger('client');
            $table->foreign('client')
                ->references('id')->on('clients')
                ->inDelete('set null');
            $table->unsignedBigInteger('contact');
            $table->foreign('contact')
                ->references('id')->on('contact_client')
                ->inDelete('set null');
            $table->unsignedBigInteger('address');
            $table->foreign('address')
                ->references('id')->on('address_client')
                ->inDelete('set null');

            $table->unsignedBigInteger('holder');
            $table->foreign('holder')
                ->references('id')->on('holder_client')
                ->inDelete('set null');
            $table->unsignedBigInteger('address_holder');
            $table->foreign('address_holder')
                ->references('id')->on('holder_address')
                ->inDelete('set null');
            $table->string('industrial_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trademark');
    }
};
