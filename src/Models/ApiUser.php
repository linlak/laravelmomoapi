<?php
namespace LaMomo\MomoApp\Models;
use Illuminate\Database\Eloquent\Model;
use LaMomo\MomoApp\Commons\MomoTables;

class ApiUser extends Model
{	
	protected $table=MomoTables::API_USER;
	protected $primaryKey="uuid";
	protected $keyType = 'string';
	public $incrementing =false;
}