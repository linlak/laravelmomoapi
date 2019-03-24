# Laravel  Momo api php Library #

This is a simple but rich php library that has been designed to enable Laravel Developers to easily integrate the Momo api into their systems or projects.

## Before we get started ##

We assume that You have composer installed on your computer and you have a laravel project or you have good knowlege working with Laravel.

	As you have read this library has been designed for laravel developers.
	
	If you are not designing or developing with lavel, we also have something for you.
	
[https://packagist.org/packages/linlak/momoapi](https://packagist.org/packages/linlak/momoapi "Check")

## Installation ##

For this library to run perfectly we assume that you have installed the following development tools

- A server with at least PHP 7.1, MySQL.
- Composer - a php dependency management tool
- You must have good skills developing with laravel (recommended v5.8) 
- Never wanted to mention a good text editor but we assume you have one installed


		composer require linlak/laravelmomoapi

Run the command about in project directory to down the dependency files.

## Initialization ##

Go to config/app.php look for **providers** and add the following code

	'providers' => [
		//.........
			LaMomo\MomoApp\MomoApiServiceProvider::class,
		//...........
	]
	
Then in the same file look for **aliases**  add the following code

	'aliases'=>[
		//.........
			'Momo' => LaMomo\MomoApp\Facades\LaMomo::class,
		//........
	]
	
We are almost there, but we need to set-up our environment variables. Open the .env file and the following line at the end.

	LAMOMO_API_COLLECTION_P_KEY=
	LAMOMO_API_COLLECTION_S_KEY=


	LAMOMO_API_DISBURSEMENTS_P_KEY=
	LAMOMO_API_DISBURSEMENTS_S_KEY=

	LAMOMO_API_REMITTANCES_P_KEY=
	LAMOMO_API_REMITTANCES_S_KEY=

	LAMOMO_API_ENVIRONMENT=sandbox

If you notice how the variable are set it is self explanatory. If you alter the definitions you will not get the desired results. 
Fill in the the api keys for the respective apis and the api environment. 

**Note:**  Before you initialize any product, make sure you have entered the required apiKeys.

You should define variables as in the example below.

	LAMOMO_API_COLLECTION_P_KEY=3f67974d9bc342c880cdfgb9c30998539
	LAMOMO_API_COLLECTION_S_KEY=5hgj7974d9bc342c88060ab9c30954358
	
Don't wrap variables in quotes.
Variables with

.....P_KEY  denote primary keys

....S_KEY denote secondary keys

Never exchange primary keys for secondary keys else you will never get the desired results.

Let's perform migrations

	php artisan migrate -v
	
We are now done setting up the necessary configurations now when you  run the migrate command the tables required for this library to  run well will be created.

## Examples ##

The following code snippets will walk through the process of working this php laravel library but conventions may differ according to your coding 
practices.










	
