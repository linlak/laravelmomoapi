<?php
namespace LaMomo\MomoApp\Models;
use Illuminate\Database\Eloquent\Model;

class MomoProduct extends Model
{	
	protected $primaryKey="referenceId";
	protected $keyType = 'string';
	public $incrementing =false;
	public function apiUser()
	{
		return $this->belongsTo('LaMomo\MomoApp\Models\ApiUser','uuid','uuid');
	}
}