<?php

namespace LaMomo\MomoApp\Products;

use LaMomo\MomoApp\MomoApp;
use LaMomo\MomoApp\Commons\MomoLinks;


use LaMomo\MomoApp\Traits\TransfersFunds;

/**
 * 
 */
class Remittances extends MomoApp
{
	use TransfersFunds;

	protected $token_uri = MomoLinks::R_TOKEN_URI;
	protected $account_holder_uri = MomoLinks::R_ACCOUNT_HOLDER_URI;
	protected $balance_uri = MomoLinks::R_BALANCE_URI;
	protected $transfer_uri = MomoLinks::R_TRANSFER_URI;

	function __construct($apiPrimaryKey, $apiSecondary, $environ = 'sandbox')
	{
		parent::__construct($apiPrimaryKey, $apiSecondary, $environ);
	}
}
