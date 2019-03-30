<?php
trait TransfersFunds{
	
	use PerformsTransfers;
	
	public function transferStatus($referenceId){
		
			return $this->requestToPayStatus($referenceId);
	}

	public function transfer(RequestToPay $requestBody,$callbackUri=false){
		
		return $this->requestToPay($requestToPay,$callbackUri);
	}
}