<?php

namespace LaMomo\MomoApp\Models;

use LaMomo\MomoApp\Commons\MomoTables;

class Disbursent extends MomoProduct
{
	protected $table = MomoTables::API_DISBURSEMENTS;

	public function disbursable()
	{
		return $this->morphTo();
	}
}
