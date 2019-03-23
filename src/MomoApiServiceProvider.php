<?php
namespace LaMomo\MomoApp;

use Illuminate\Support\ServiceProvider;

class MomoApiServiceProvider extends ServiceProvider
{
	
	public function boot()
	{
		
	}
	public function register()
	{
		# code...
		$this->loadLinMigrations();
	}
	protected function loadLinMigrations(){
		$this->loadMigrationsFrom(__DIR__.'/Database/migrations');
	}
}