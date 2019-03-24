<?php
namespace LaMomo\MomoApp\Facades;
use Illuminate\Support\Facades\Facade;
/**
* 
*/
class LaMomo extends Facade
{
	
	protected static function getFacadeAccessor()
    {
        return 'momo';
    }
}