<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToNeighbors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('neighbors', function (Blueprint $table) {
            $table->string('status')->default('pending'); //pending, accepted,  denied  // admin should be always accepted

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('neighbors', function (Blueprint $table) {
            //
        });
    }
}
