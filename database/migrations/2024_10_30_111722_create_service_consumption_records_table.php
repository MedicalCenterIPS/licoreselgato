<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(env('DB_SINTAX') . 'service_consumption_records', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_site_service')->unsigned();
            $table->foreign('id_site_service')->references('id')->on('hc_sites');
            $table->string('account');
            $table->string('company_service_consumption');
            $table->string('month');
            $table->integer('year');
            $table->integer('amount');
            $table->string('measurement_unit');
            $table->string('type_service');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(env('DB_SINTAX') . 'service_consumption_records');
    }
};
