<?php
namespace LaMomo\MomoApp;
use Illuminate\Support\Carbon;

use LaMomo\MomoApp\Commons\MomoTables;

use LaMomo\MomoApp\Products\Collections;
use LaMomo\MomoApp\Products\Disbursements;
use LaMomo\MomoApp\Products\Remittances;

use LaMomo\MomoApp\Responses\TokenResponse;
//modls
use LaMomo\MomoApp\Models\AccessToken;
use LaMomo\MomoApp\Models\ApiUser;

use LaMomo\MomoApp\Models\Collection;
use LaMomo\MomoApp\Models\Disbursement;
use LaMomo\MomoApp\Models\Remittance;
use Illuminate\Support\Facades\Date;
/**
* 
*/
class Bootstraper
{
	// use Carbon\Traits
	private $cPriKey,$cSecKey,$dPriKey,$dSecKey,$rPriKey,$rSecKey;
	private $environ;
	private $isCollection=false;
	private $isRemittances=false;
	private $isDisbursements=false;
	private $cCallback="";
	private $dCallback="";
	private $rCallback="";
	function __construct()
	{
		# code...
		$this->init();
	}
	private function init(){

		$this->cPriKey=config('momo.momo_api_collection_p_key');
		$this->cSecKey=config('momo.momo_api_collection_s_key');

		$this->dPriKey=config('momo.momo_api_disbursement_p_key');
		$this->dSecKey=config('momo.momo_api_disbursement_s_key');

		$this->rPriKey=config('momo.momo_api_remittance_p_key');
		$this->rSecKey=config('momo.momo_api_remittance_s_key');

		$this->environ=config('momo.momo_api_environ');

		if ($this->cPriKey!==""&&$this->cSecKey!=="") {
			$this->isCollection=true;
		}
		if ($this->dPriKey!==""&&$this->dSecKey!=="") {
			$this->isDisbursements=true;
		}
		if ($this->rPriKey!==""&&$this->rSecKey!=="") {
			$this->isRemittances=true;
		}
	}
	
	public function initCollections(){
		
		if ($this->isCollection) {
			$momo=new Collections($this->cPriKey,$this->cSecKey,$this->environ);			
			if($apiUser=$this->checkApiUser($this->cPriKey,$this->cSecKey))
			{
				$this->setMomo($momo,$apiUser);	
				// return $apiUser;			
				return $momo;
			}else{
				if ($apiUser=$this->insertNewApiUser($momo,$this->cPriKey,$this->cSecKey,'Collection')) {
					$this->setMomo($momo,$apiUser);
				}
			}
			return $momo;
		}
		else{
			//throw error
		}
		return false;
	}
	public function initDisbursements(){
		if ($this->isDisbursements) {
			$momo=new Disbursements($this->dPriKey,$this->dSecKey,$this->environ);
			if($apiUser=$this->checkApiUser($this->cPriKey,$this->cSecKey))
			{
				$this->setMomo($momo,$apiUser);	
				return $apiUser;			
				// return $momo;
			}else{
				if ($apiUser=$this->insertNewApiUser($momo,$this->cPriKey,$this->cSecKey,'Disbursement')) {
					$this->setMomo($momo,$apiUser);
				}
			}
			return $momo;
		}
		else{
			//throw error
		}
	}
	public function initRemittances(){
		if ($this->isRemittances) {
			$momo=new Remittances($this->rPriKey,$this->rSecKey,$this->environ);
			if($apiUser=$this->checkApiUser($this->cPriKey,$this->cSecKey))
			{
				$this->setMomo($momo,$apiUser);	
				return $apiUser;			
				// return $momo;
			}else{
				if ($apiUser=$this->insertNewApiUser($momo,$this->cPriKey,$this->cSecKey,'Remittance')) {
					$this->setMomo($momo,$apiUser);
				}
			}
			return $momo;
		}
		else{
			//throw error
		}
	}
	private function setMomo(MomoApp $momo,ApiUser $apiUser){

				$momo->setApiUserId($apiUser->uuid);

				if (""!==(string)$apiUser->api_key) {

					$momo->setApiKey($apiUser->api_key);

					var_dump(date($apiUser->accessToken->expires_at));

					exit();
					if ( ($apiUser->accessToken===null) || ($apiUser->AccessToken!==null && (string)$apiUser->AccessToken->access_token==="")||((string)$apiUser->AccessToken->expires_at==="")||((string)$apiUser->AccessToken->expires_at!==""&&($apiUser->accessToken->expires_at->diffInSeconds($apiUser->accessToken->freshTimestamp()) <= $apiUser->accessToken->expires_in)) ) {

						if ($result=$momo->requestToken()) {
							$this->saveApiToken($result,$apiUser);
						}						

					}

					$momo->setApiToken($apiUser->accessToken->access_token);				

				}else{

					$this->getApikey($momo,$apiUser);

					$momo->setApiKey($apiUser->api_key);
				}
	}
	private function insertNewApiUser(MomoApp $momo,$api_primary,$api_secondary,$product,$callBack=null,$liveCong=array()){	
		$newUser=new ApiUser();
		$cBackUrl="";
		switch ($product) {
			case 'Collection':			
				$cBackUrl=$this->cCallback;
				break;
			case 'Disbursement':
				$cBackUrl=$this->dCallback;
				break;
			case 'Remittance':
				$cBackUrl=$this->rCallback;
				break;
		}
		
				
		if ($this->environ==="sandbox") {
			if ($res=$momo->createApiUser($cBackUrl)) {
			if ($res->isCreated()) {	
				$newUser->uuid=$res->getUid();
				$newUser->api_primary=$api_primary;
				$newUser->api_secondary=$api_secondary;
				$newUser->product=$product;
				$newUser->callback_url=$cBackUrl;				
					if($newUser->save()){
						if($apiUser=$this->checkApiUser($api_primary,$api_secondary))
							{
								$momo->setApiUserId($apiUser->uuid);
								if (""!==(string)$apiUser->api_key) {
									$momo->setApiKey($apiUser->api_key);
								}else{
								$this->getApikey($momo,$apiUser);
								$momo->setApiKey($apiUser->api_key);						
								}
							}
							return $apiUser;
					}
				}
			}
		}else{
			//add live credentials
		}		
		return false;
	}
	private function getApiKey(MomoApp $momo,$apiUser){
		if ($res=$momo->getApikey()) {
			if ($res->isUser()) {
				$apiUser->api_key=$res->getApiKey();
				if($apiUser->save()){
					$apiUser->refresh();
				}
			}
		}
	}
	public function checkApiUser($api_primary,$api_secondary){
		
		if($apiUser=ApiUser::with('accessToken')->where('api_primary','=',$api_primary)->where('api_secondary','=',$api_secondary)->get()->first())
			{
			
				return $apiUser;
			}
		 return false;
	}
	public function saveApiToken(TokenResponse $response,ApiUser $apiUser){
		
		if ($response->isCreated()) {
				$tk=new AccessToken();
				$tk->uuid=$apiUser->uuid;
				$tk->access_token=$response->getAccessToken();
				$tk->token_type=$response->getTokenType();
				$tk->expires_in=$response->getExpiresIn();
				$tk->created_at=$apiUser->accessToken->freshTimestamp()->add('second',$response->getExpiresIn());
				$tk->forcefill(['expires_at'=>Carbon::now()->add('second',$response->getExpiresIn())]);
				(new AccessToken())->updateOrCreate(['uuid'=>$tk->uuid],$tk->toArray());
				$apiUser->refresh();				
			}
		}
	
}