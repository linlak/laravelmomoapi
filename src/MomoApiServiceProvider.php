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
		$this->app->alias('momo', Bootstraper::class);
		$this->registerBootstraper();
	}
	protected function loadLinMigrations(){
		$this->loadMigrationsFrom(__DIR__.'/Database/migrations');
	}
	protected function registerBootstraper(){
		$this->app->singleton('momo',function($app){
			return new Bootstraper();
		});
	}
	 public function provides()
	
    {
        return ['momo', Bootstraper::class];
    }
}