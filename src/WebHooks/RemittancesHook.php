<?php
namespace LaMomo\MomoApp\WebHooks;

use LaMomo\MomoApp\Models\Remittance;
/**
 * 
 */
class RemittancesHook 
{
	
	private $momo;
	
	function __construct(Remittance $momo)
	{
		$this->momo=$momo;
	}
}