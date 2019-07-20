<?php

namespace LaMomo\MomoApp\WebHooks;

use LaMomo\MomoApp\Models\Disbursement;
use Illuminate\Support\Collection;

/**
 * 
 */
class DisbursementsHook
{

	private $momo;

	function __construct(Disbursement $momo)
	{
		$this->momo = $momo;
	}
	public function checkStatus(Collection $data)
	{
		try {
			$pay = Disbursement::with('disbursable')->where('disbursable_id', '=', $data->get('externalId'))->get()->first();
			if (!is_null($pay)) {
				if (!\is_null($pay->disbursable)) {
					$this->momo->transferStatus($pay);
				} else {
					$pay->delete();
				}
			}
		} catch (\Exception $e) {
			Log::error('DisbursementsHook: ' . $e->getMessage());
		}
	}
}
