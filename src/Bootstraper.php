<?php
namespace LaMomo\MomoApp;

use LaMomo\MomoApp\Products\Collections;
use LaMomo\MomoApp\Products\Disbursements;
use LaMomo\MomoApp\Products\Remittances;

//modls
use LaMomo\MomoApp\Models\AccessToken;
use LaMomo\MomoApp\Models\ApiUser;

use LaMomo\MomoApp\Models\Collection;
use LaMomo\MomoApp\Models\Disbursement;
use LaMomo\MomoApp\Models\Remittance;
/**
* 
*/
class Bootstraper
{
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
		$this->cPriKey=env('LAMOMO_API_COLLECTION_P_KEY',"");
		$this->cSecKey=env('LAMOMO_API_COLLECTION_S_KEY',"");
		$this->dPriKey=env('LAMOMO_API_DISBURSEMENTS_P_KEY',"");
		$this->dSecKey=env('LAMOMO_API_DISBURSEMENTS_S_KEY',"");
		$this->rPriKey=env('LAMOMO_API_REMITTANCES_P_KEY',"");
		$this->rSecKey=env('LAMOMO_API_REMITTANCES_S_KEY',"");
		$this->environ=env('LAMOMO_API_ENVIRONMENT',"sandbox");
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
				return $apiUser;			
				// return $momo;
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

					if ($apiUser->access_token===null&&(string)$apiUser->AccessToken->access_token==="") {
						
						$tk=new AccessToken();
						$tk->uuid=$apiUser->uuid;
						$tk->access_token="itghffgffgkhdfghjlkjhjh";
						$tk->token_type='access_token';
						$tk->expires_in=3600;
						// $tk->created_at=3600;
						// $expires_at="DATE_ADD(NOW(), INTERVAL ".$tk->expires_in." SECOND)";
						// echo($expires_at);
						(new AccessToken())->updateOrCreate(['uuid'=>$tk->uuid],$tk->toArray());
						$apiUser->refresh();

					}else{
						$momo->setApiToken($apiUser->accessToken->access_token);
					}					

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
	
}