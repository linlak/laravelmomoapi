<?php
namespace LaMomo\MomoApp\Products;
use LaMomo\MomoApp\MomoApp;
/**
* 
*/
class Collections extends MomoApp
{
	
	function __construct($apiPrimaryKey,$apiSecondary,$environ='sandbox')
	{
		parent::__construct($apiPrimaryKey,$apiSecondary,$environ);
	}
}