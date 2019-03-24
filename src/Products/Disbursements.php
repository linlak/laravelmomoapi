<?php
namespace LaMomo\MomoApp\Products;
use LaMomo\MomoApp\MomoApp;
/**
* 
*/
class Disbursements extends MomoApp
{
	
	function __construct($apiPrimaryKey,$apiSecondary,$environ='sandbox')
	{
		parent::__construct($apiPrimaryKey,$apiSecondary,$environ);
	}
}