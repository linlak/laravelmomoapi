<?php

namespace LaMomo\MomoApp\Models;

use LaMomo\MomoApp\Commons\MomoTables;

class Collection extends MomoProduct
{
	protected $table = MomoTables::API_COLLECTION;

	public function collectionable()
	{
		return $this->morphTo();
	}
}
