<?php
namespace LaMomo\MomoApp\Products;
use LaMomo\MomoApp\MomoApp;
use LaMomo\MomoApp\Models\RequestToPay;
use LaMomo\MomoApp\Commons\MomoLinks;
use LaMomo\MomoApp\Commons\Constants;

use LaMomo\MomoApp\Responses\TokenResponse;
use LaMomo\MomoApp\Responses\BalanceResponse;
use LaMomo\MomoApp\Responses\RequestToPayResponse;
use LaMomo\MomoApp\Responses\RequestStatus;

use LaMomo\MomoApp\Interfaces\CollectionInterface;
/**
* 
*/
class Collections extends MomoApp implements CollectionInterface
{
	
	function __construct($apiPrimaryKey,$apiSecondary,$environ='sandbox')
	{
		parent::__construct($apiPrimaryKey,$apiSecondary,$environ);
	}
	public function requestToken()
	{		
		$this->setApiToken("");
		$this->setAuth();
		$response = $this->send($this->genRequest("POST",MomoLinks::TOKEN_URI));
		return new TokenResponse($response);
	}
	public function acountHolder($accountHolderIdType,$accountHolderId){
		$this->setAuth();		
		return $this->send($this->genRequest("GET",MomoLinks::ACOUNT_HOLDER_URI.$accountHolderIdType.'/'.$accountHolderId.'/active'));
	}

	public function requestToPay(RequestToPay $requestBody,$callbackUri=false){
		$referenceId=$this->gen_uuid();
		$this->setHeaders(Constants::H_REF_ID,$referenceId);
		$this->setAuth();
		if (false!==$callbackUri) {
			$this->setHeaders(Constants::H_CALL_BACK,$callbackUri);
		}
		if ($this->environ==='sandbox') {
			$requestBody->setCurrency('EUR');
		}
		$response= $this->send($this->genRequest("POST",MomoLinks::REQUEST_TO_PAY_URI,$requestBody->generateRequestBody()));

		$result=new RequestToPayResponse($response,$referenceId,$requestBody);

		if ($result->isAccepted()) {
			return $this->db->saveRequestToPay($result,$this->apiPrimaryKey,$this->apiSecondary);
		}
		return false;
	}
	public function requestToPayStatus($referenceId){
		if($payt=$this->db->getPayment($referenceId,$this->apiPrimaryKey,$this->apiSecondary)){
			if ($payt['status']==="PENDING") {
				$this->setAuth();
				$response= $this->send($this->genRequest("GET",MomoLinks::REQUEST_TO_PAY_URI.'/'.$referenceId));
				$result=new RequestStatus($response,$referenceId);
				if ($this->db->updateRequestToPay($result,$this->apiPrimaryKey,$this->apiSecondary)) {
					$payt=$this->db->getPayment($referenceId,$this->apiPrimaryKey,$this->apiSecondary);
				}
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
	public function requestBalance(){
		$this->setAuth();
		$response = $this->send($this->genRequest("GET",MomoLinks::BALANCE_URI));	

		return new BalanceResponse($response);
		
	}
}