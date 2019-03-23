<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use LaMomo\MomoApp\Commons\MomoTables;

class CreateMomoApiUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(MomoTables::API_USER, function (Blueprint $table) {
            MomoTables::apiUserTable($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(MomoTables::API_USER);
    }
}
