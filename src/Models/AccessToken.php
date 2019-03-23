<?php
namespace LaMomo\MomoApp\Models;
use Illuminate\Database\Eloquent\Model;
use LaMomo\MomoApp\Commons\MomoTables;

class AccessToken extends Model
{	
	protected $table=MomoTables::API_TOKENS;
	protected $primaryKey="uuid";
	protected $keyType = 'string';
	public $incrementing =false;
}