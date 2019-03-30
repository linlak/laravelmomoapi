<?php
namespace LaMomo\MomoApp\Products;
use LaMomo\MomoApp\MomoApp;

use LaMomo\MomoApp\Models\RequestToPay;
use LaMomo\MomoApp\Commons\MomoLinks;

use LaMomo\MomoApp\Traits\TransfersFunds;
/**
* 
*/
class Disbursements extends MomoApp
{
	use TransfersFunds;

	protected $token_uri=MomoLinks::D_TOKEN_URI;
	protected $account_holder_uri=MomoLinks::D_ACCOUNT_HOLDER_URI;
	protected $balance_uri=MomoLinks::D_BALANCE_URI;
	protected $transfer_uri=MomoLinks::D_TRANSFER_URI;

	function __construct($apiPrimaryKey,$apiSecondary,$environ='sandbox')
	{
		parent::__construct($apiPrimaryKey,$apiSecondary,$environ);
	}
}