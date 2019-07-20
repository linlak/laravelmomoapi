<?php

namespace LaMomo\MomoApp\Traits;

use Illuminate\Database\Eloquent\Model;
use LaMomo\MomoApp\Models\RequestToPay;

trait TransfersFunds
{

	use PerformsTransfers;

	public function transferStatus(Model $model)
	{

		return $this->requestToPayStatus($model);
	}

	public function transfer(RequestToPay $requestBody, Model $morph, $callbackUri = false)
	{

		$this->requestToPay($requestBody, $morph, $callbackUri);
	}
}
