<?php
namespace LaMomo\MomoApp\Traits;

use LaMomo\MomoApp\Commons\MomoLinks;
use LaMomo\MomoApp\Commons\Constants;

use LaMomo\MomoApp\Responses\ApiUserResponse;
use LaMomo\MomoApp\Responses\ApiKeyResponse;
use LaMomo\MomoApp\Responses\ApiUserInfoResponse;
use LaMomo\MomoApp\Responses\TokenResponse;

use Illuminate\Support\Str;

trait CreatesApiUser{
	protected $environ="sandbox";//live
	protected $apiPrimaryKey,$apiSecondary;
	protected $apiKey='';
	private $apiToken='';
	protected $apiUserId='';
	protected $headers=[
		// "Content-Length"=>0,
		Constants::H_AUTH=>"",
		Constants::H_ENVIRON=>"",
		// Constants::H_REF_ID=>"",
		Constants::H_C_TYPE=>"",
		Constants::H_OCP_APIM=>""
	];
	private $_client;
	protected $token_uri="";
	protected $account_holder_uri="";

	public function requestToken()
	{		
		$this->setApiToken("");
		$this->setAuth();
		$response = $this->send($this->genRequest("POST",$this->token_uri));
		return new TokenResponse($response);
	}
	public function acountHolder($accountHolderIdType,$accountHolderId){
		$this->setAuth();		
		return $this->send($this->genRequest("GET",$this->account_holder_uri.$accountHolderIdType.'/'.$accountHolderId.'/active'));
	}
	public function createApiUser($providerCallbackHost){
		$uid=Str::uuid();
		$this->setHeaders(Constants::H_REF_ID,$uid);
		$this->removeHeader(Constants::H_AUTH);
		$this->removeHeader(Constants::H_ENVIRON);
		$body=['providerCallbackHost'=>$providerCallbackHost];
		$result=$this->send($this->genRequest("POST",MomoLinks::USER_URI,$body));
		return new ApiUserResponse($result,$uid);
	}
	public function getApiUser(){
		$this->removeHeader(Constants::H_AUTH);
		$this->removeHeader(Constants::H_ENVIRON);
		$result=$this->send($this->genRequest("GET",MomoLinks::USER_URI.'/'.$this->apiUserId));
		return new ApiUserInfoResponse($result,$this->apiUserId);
	}
	public function getApikey(){
		$this->removeHeader(Constants::H_AUTH);
		$this->removeHeader(Constants::H_ENVIRON);
		$result=$this->send($this->genRequest("POST",MomoLinks::USER_URI.'/'.$this->apiUserId.'/apikey'));
		return new ApiKeyResponse($result,$this->apiUserId);
	}

}