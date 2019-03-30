<?php
namespace LaMomo\MomoApp\Products;
use LaMomo\MomoApp\MomoApp;

use LaMomo\MomoApp\Commons\MomoLinks;

use LaMomo\MomoApp\Traits\PerformsTransfers;

/**
* 
*/
class Collections extends MomoApp
{
	
	use PerformsTransfers;

	protected $token_uri=MomoLinks::TOKEN_URI;
	protected $account_holder_uri=MomoLinks::ACOUNT_HOLDER_URI;
	protected $balance_uri=MomoLinks::BALANCE_URI;
	protected $transfer_uri=MomoLinks::REQUEST_TO_PAY_URI;

	function __construct($apiPrimaryKey,$apiSecondary,$environ='sandbox')
	{
		parent::__construct($apiPrimaryKey,$apiSecondary,$environ);
	}
	
}