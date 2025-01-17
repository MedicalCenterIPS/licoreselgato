<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionUnitsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(env('DB_SINTAX') . 'production_units', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_site')->unsigned();
            $table->foreign('id_site')->references('id')->on('hc_sites');
            $table->bigInteger('id_type')->unsigned();
            $table->foreign('id_type')->references('id')->on('hc_type_collaborators');
            $table->string('month');
            $table->string('company');
            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(env('DB_SINTAX') . 'production_units');
    }
};
