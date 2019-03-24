<?php
namespace LaMomo\MomoApp;

use LaMomo\MomoApp\Products\Collections;
use LaMomo\MomoApp\Products\Disbursements;
use LaMomo\MomoApp\Products\Remittances;

//modls
use LaMomo\MomoApp\Models\AcceccToken;
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
		/*
				Array
		(
		    [uuid] => 19fa08cc-4e08-11e9-8947-00ffd1d0ef7b
		    [api_primary] => gyfcfghbhnj
		    [api_secondary] => fghjljltrsdb
		    [product] => Collection
		    [api_key] => fghjolkjhfghj
		    [callback_url] => momo.autobitzltd.com
		    [created_at] => 
		    [updated_at] => 
		    [access_token] => 
		)
				*/
		if ($this->isCollection) {
			$momo=new Collections($this->cPriKey,$this->cSecKey,$this->environ);			
			if($apiUser=$this->checkApiUser($this->cPriKey,$this->cSecKey))
			{
				$momo->setApiUserId($apiUser['uuid']);
				if (""!==(string)$apiUser['api_key']) {
					$momo->setApiKey($apiUser['api_key']);
					/*if ($apiUser['access_token']===null) {
						# code...
						//
					}*/
					return $apiUser['access_token'];
				}else{
					if ($apiUser=$this->getApikey($momo,$apiUser)) {
						$momo->setApiKey($apiUser['api_key']);							
					}
				}
				return $momo;
			}else{
				if ($apiUser=$this->insertNewApiUser($momo,$this->cPriKey,$this->cSecKey,'Collection')) {
					$momo->setApiUserId($apiUser['uuid']);
					$momo->setApiKey($apiUser['api_key']);
				}
			}
			return $momo;
		}
		else{
			//throw error
		}
		return false;
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
								$momo->setApiUserId($apiUser['uuid']);
								if (""!==(string)$apiUser['api_key']) {
									$momo->setApiKey($apiUser['api_key']);
								}else{
										if ($apiUser=$this->getApikey($momo,$apiUser)) {
											$momo->setApiKey($apiUser['api_key']);
										}
								}
								return $apiUser;
							}
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
				$newUser=ApiUser::where('uuid','=',$apiUser['uuid'])->get()->first();
				// $newUser->uuid=$apiUser['uuid'];
				$newUser->api_key=$res->getApiKey();
				if($newUser->save()){
					return $this->checkApiUser($apiUser['api_primary'],$apiUser['api_secondary']);
				}
			}
		}
		return false;
	}
	public function checkApiUser($api_primary,$api_secondary){

		if($apiUser=ApiUser::with('accessToken')->where('api_primary','=',$api_primary)->where('api_secondary','=',$api_secondary)->get()->first())
			{
				return $apiUser->toArray();
			}
		return false;
	}
	public function initDisbursements(){
		if ($this->isDisbursements) {
			$momo=new Disbursements($this->dPriKey,$this->dSecKey,$this->environ);
			return $momo;
		}
		else{
			//throw error
		}
	}
	public function initRemittances(){
		if ($this->isRemittances) {
			$momo=new Remittances($this->rPriKey,$this->rSecKey,$this->environ);
			return $momo;
		}
		else{
			//throw error
		}
	}
}