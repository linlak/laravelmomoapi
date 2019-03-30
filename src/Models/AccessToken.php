<?php
namespace LaMomo\MomoApp\Models;
use Illuminate\Database\Eloquent\Model;
use LaMomo\MomoApp\Commons\MomoTables;

class AccessToken extends Model
{	
	protected $table=MomoTables::API_TOKENS;
	protected $primaryKey="uuid";
	protected $keyType = 'string';
	protected $fillable=['uuid','access_token','token_type','expires_in','created_at','expires_at'];
	public $incrementing =false;
	public function apiUser()
	{
		return $this->belongsTo('LaMomo\MomoApp\Models\ApiUser','uuid','uuid');
	}
	
}