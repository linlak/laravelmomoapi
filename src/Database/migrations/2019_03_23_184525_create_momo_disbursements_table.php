<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use LaMomo\MomoApp\Commons\MomoTables;

class CreateMomoDisbursementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(MomoTables::API_DISBURSEMENTS, function (Blueprint $table) {
            MomoTables::productsTable($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(MomoTables::API_DISBURSEMENTS);
    }
}
