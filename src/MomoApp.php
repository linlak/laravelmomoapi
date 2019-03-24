<?php
namespace LaMomo\MomoApp;
/**
* 
*/
class MomoApp 
{
	protected $environ="sandbox";//live
	protected $apiVersion='v1_0';
	protected $baseUri = 'https://ericssonbasicapi2.azure-api.net/';
	protected $apiPrimaryKey,$apiSecondary;
	protected $apiKey='';
	private $apiToken='';
	protected $apiUserId='';
	protected $db=null;
	protected $headers=[
		// "Content-Length"=>0,
		Constants::H_AUTH=>"",
		Constants::H_ENVIRON=>"",
		// Constants::H_REF_ID=>"",
		Constants::H_C_TYPE=>"",
		Constants::H_OCP_APIM=>""
	];
	private $_client;
	function __construct()
	{
		
	}
}