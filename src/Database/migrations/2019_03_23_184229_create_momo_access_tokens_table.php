<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use LaMomo\MomoApp\Commons\MomoTables;

class CreateMomoAccessTokensTable extends Migration
{
   
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(MomoTables::API_TOKENS, function (Blueprint $table) {
           MomoTables::accessTokenTable($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(MomoTables::API_TOKENS);
    }
}
