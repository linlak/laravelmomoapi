<?php
namespace LaMomo\MomoApp\Traits;

use LaMomo\MomoApp\Responses\BalanceResponse;

trait ChecksBalance{
	// protected $balance_uri="url";
	public function requestBalance(){
		$this->setAuth();
		$response = $this->send($this->genRequest("GET",$this->balance_uri));	

		return new BalanceResponse($response);
		
	}
}