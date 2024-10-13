<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableUsers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table(env('DB_SINTAX') . 'users', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
            $table->string('azure_id')->nullable()->after('password');
            $table->string('modo_auth')->nullable()->after('azure_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
    }
};
