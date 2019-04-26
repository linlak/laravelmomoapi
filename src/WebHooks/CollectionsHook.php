<?php
namespace LaMomo\MomoApp\WebHooks;

use LaMomo\MomoApp\Models\Collection;

/**
 * 
 */
class CollectionsHook 
{
	
	private $momo;
	
	function __construct(Collection $momo)
	{
		$this->momo=$momo;
	}
}