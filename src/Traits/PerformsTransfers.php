<?php
namespace LaMomo\MomoApp\Traits;

use LaMomo\MomoApp\Commons\Constants;

use LaMomo\MomoApp\Models\RequestToPay;
use LaMomo\MomoApp\Responses\BalanceResponse;
use LaMomo\MomoApp\Responses\RequestToPayResponse;
use LaMomo\MomoApp\Responses\RequestStatus;

use Illuminate\Support\Str;

trait PerformsTransfers{
	// protected $transfer_uri="";
	use ChecksBalance;
	public function requestToPay(RequestToPay $requestBody,$callbackUri=false){

		$referenceId=Str::uuid();
		$this->setHeaders(Constants::H_REF_ID,$referenceId);
		$this->setAuth();
		if (false!==$callbackUri) {
			$this->setHeaders(Constants::H_CALL_BACK,$callbackUri);
		}
		if ($this->environ==='sandbox') {
			$requestBody->setCurrency('EUR');
		}
		
		$response= $this->send($this->genRequest("POST",$this->transfer_uri,$requestBody->generateRequestBody()));

		$result=new RequestToPayResponse($response,$referenceId,$requestBody);

		if ($result->isAccepted()) {
				

			return $this->db->saveRequestToPay($result,$this->apiPrimaryKey,$this->apiSecondary);
		}
		return false;
	}
	public function requestToPayStatus($referenceId){

		if($payt=$this->db->getPayment($referenceId,$this->apiPrimaryKey,$this->apiSecondary)){
			
			if ($payt->status==="PENDING") {
				$this->setAuth();
				$response= $this->send($this->genRequest("GET",$this->transfer_uri.'/'.$referenceId));				

				$result=new RequestStatus($response,$referenceId);
				$this->db->updateRequestToPay($result,$payt);
			}	
			return $payt;		
		}
		return false;
	}
	
	/*public function requestPreAproval(RequestToPay $requestBody,$callbackUri=false){
		$referenceId=$this->gen_uuid();
		$this->setHeaders(Constants::H_REF_ID,$referenceId);
		$this->setAuth();
		if (false!==$callbackUri) {
			$this->setHeaders(Constants::H_CALL_BACK,$callbackUri);
		}
		if ($this->environ==='sandbox') {
			$requestBody->setCurrency('EUR');
		}
		$response=$this->send($this->genRequest("POST",MomoLinks::PRE_APPROVAL_URI,$requestBody->generateRequestBody()));
		$result=new RequestToPayResponse($response,$referenceId,$requestBody);
		if ($result->isAccepted()) {
			return $this->db->saveRequestToPay($result,$this->apiPrimaryKey,$this->apiSecondary);
		}
		return false;

	}*/
	/*public function requestPreAprovalStatus($referenceId){
		if($payt=$this->db->getPayment($referenceId,$this->apiPrimaryKey,$this->apiSecondary)){
			if ($payt['status']==="PENDING") {
				$this->setAuth();
				$response= $this->send($this->genRequest("GET",MomoLinks::PRE_APPROVAL_URI.'/'.$referenceId));
				$result=new RequestStatus($response,$referenceId);
				if ($this->db->updateRequestToPay($result,$this->apiPrimaryKey,$this->apiSecondary)) {
					$payt=$this->db->getPayment($referenceId,$this->apiPrimaryKey,$this->apiSecondary);
				}
			}	
			return $payt;		
		}
		return false;
	}*/

}