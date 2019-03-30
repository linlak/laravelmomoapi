<?
namespace LaMomo\MomoApp\Listeners;

class MomoEventSubscriber
{


	public function deletePayment($event){}


	public function subscribe($events)
	{
		
		$events->listen(
            'LaMomo\MomoApp\Events\CollectionDeleted',
            'LaMomo\MomoApp\Listeners\MomoEventSubscriber@deletePayment'
        );
        
	}
}