<?php

namespace LaMomo\MomoApp\WebHooks;

use LaMomo\MomoApp\Products\Remittances;
use Illuminate\Support\Collection;
use LaMomo\MomoApp\Models\Remittance;
use Illuminate\Support\Facades\Log;

/**
 * 
 */
class RemittancesHook
{

	private $momo;

	function __construct(Remittances $momo)
	{
		$this->momo = $momo;
	}

	public function checkStatus(Collection $data)
	{
		try {
			$pay = Remittance::with('remittable')->where('remittable_id', '=', $data->get('externalId'))->get()->first();
			if (!is_null($pay)) {
				if (!\is_null($pay->remittable)) {
					$this->momo->transferStatus($pay);
				} else {
					$pay->delete();
				}
			}
		} catch (\Exception $e) {
			Log::error('RemittancesHook: ' . $e->getMessage());
		}
	}
}
