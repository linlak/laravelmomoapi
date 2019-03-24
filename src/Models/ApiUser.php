<?php
namespace LaMomo\MomoApp\Models;
use Illuminate\Database\Eloquent\Model;
use LaMomo\MomoApp\Commons\MomoTables;
use AccessToken;
class ApiUser extends Model
{	
	protected $table=MomoTables::API_USER;
	protected $primaryKey="uuid";
	protected $keyType = 'string';
	public $incrementing =false;
	protected $eagerLoad = ['accessToken'];
	public function accessToken()
	{
		return $this->hasOne('LaMomo\MomoApp\Models\AccessToken','uuid','uuid');
	}
	public function payments($product){
		return $this->hasMany('LaMomo\MomoApp\Models\\'.$product,'uuid','uuid');
	}
}