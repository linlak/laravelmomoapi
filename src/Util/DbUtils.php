<?php
namespace LaMomo\MomoApp\Util;

use Illuminate\Database\Schema\Blueprint;
use LaMomo\MomoApp\Commons\MomoTables;

class DbUtils
{
	
	private function __construct()
	{
		# code...
	}
	public static function productsTable(Blueprint $table){
		$table->engine = 'InnoDB';
		$table->string('referenceId');
		$table->string('uuid');
		$table->string('amount');
		$table->string('partyIdType');
		$table->string('partyId');
		$table->string('currency');
		$table->string('externalId');
		$table->string('payerMessage');
		$table->string('financialTranactionId')->nullable();
		$table->string('payeeNote');
		$table->string('status')->default('PENDING');
		$table->string('reason')->nullable();
        $table->timestamps();
        $table->primary('referenceId');
        $table->index('uuid');
        $table->foreign('uuid')
      ->references('uuid')->on(MomoTables::API_USER)
      ->onUpdate('cascade')
      ->onDelete('cascade');
	}
	public static function apiUserTable(Blueprint $table){
		$table->engine = 'InnoDB';
		$table->string('uuid');
		$table->string('api_primary');
		$table->string('api_secondary');
		$table->string('product');
		$table->string('api_key')->nullable();
		$table->string('callback_url');
        $table->timestamps();
        $table->primary('uuid');
        $table->unique('api_primary');
        $table->unique('api_secondary');
	}
	public static function accessTokenTable(Blueprint $table){
		$table->engine = 'InnoDB';
		$table->string('uuid');
		$table->longText('access_token')->nullable();
		$table->string('token_type',20);
		$table->integer('expires_in')->default(0);
        $table->timestamp('expires_at')->nullable();
        $table->timestamps();
        $table->primary('uuid');
        $table->foreign('uuid')
	      ->references('uuid')->on(MomoTables::API_USER)
	      ->onUpdate('cascade')
	      ->onDelete('cascade');
	}
}