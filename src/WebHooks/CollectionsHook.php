<?php

namespace LaMomo\MomoApp\WebHooks;

use Illuminate\Support\Collection;
use LaMomo\MomoApp\Products\Collections;
use LaMomo\MomoApp\Models\Collection as LaMomoCollection;
use Illuminate\Support\Facades\Log;

/**
 * 
 */
class CollectionsHook
{

	private $momo;

	function __construct(Collections $momo)
	{
		$this->momo = $momo;
	}
	public function checkStatus(Collection $data)
	{
		try {
			$pay = LaMomoCollection::with('collectionable')->where('collectionable_id', '=', $data->get('externalId'))->get()->first();
			if (!\is_null($pay)) {
				if (!\is_null($pay->collectionable)) {
					$this->momo->requestToPayStatus($pay);
				} else {
					$pay->delete();
				}
			}
		} catch (\Exception $e) {
			Log::error('CollectionHook: ' . $e->getMessage());
		}
	}
}
