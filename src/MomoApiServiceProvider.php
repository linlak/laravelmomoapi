<?php
namespace LaMomo\MomoApp;

use Illuminate\Support\ServiceProvider;
use LaMomo\MomoApp\Console\Commands\InitMomo;
class MomoApiServiceProvider extends ServiceProvider
{
	
	public function boot()
	{
		
		$this->loadLinMigrations();
		$this->registerCommands();
	    $this->publishes([
	        __DIR__.'/config/momo.php' => config_path('momo.php'),
	    ]);
	}
	public function register()
	{
		# code...
		$this->mergeConfigFrom(
	        __DIR__.'/config/momo.php', 'momo'
	    );
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

    protected function registerCommands(){
    	if ($this->app->runningInConsole()) {
    		$this->commands([
    				InitMomo::class,
    		]);
    	}
    }
}