<?php
namespace LaMomo\MomoApp\WebHooks;

use LaMomo\MomoApp\Models\Disbursement;

/**
 * 
 */
class DisbursementsHook
{

	private $momo;

	function __construct(Disbursement $momo)
	{
		$this->momo=$momo;
	}
	
}