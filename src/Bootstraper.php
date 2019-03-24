<?php
namespace LaMomo\MomoApp;

use LaMomo\MomoApp\Products\Collections;
use LaMomo\MomoApp\Products\Disbursements;
use LaMomo\MomoApp\Products\Remittances;
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
	public function shoMe()
	{
		return $this;
	}
	public function initCollections(){
		if ($this->isCollection) {
			$momo=new Collections($this->cPriKey,$this->cSecKey,$this->environ);
			return $momo;
		}
		else{
			//throw error
		}
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