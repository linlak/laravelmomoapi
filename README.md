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

Run the command above in project directory to download the dependency files.

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
	
Run the follow command

	$php artisan vendor:publish
	
This will display a list of options.  Enter number corresponding with

	LaMomo\MomoApp\MomoApiServiceProvider
We are almost there, but we need to set-up our environment variables. Open config->momo.php file replace momo with api keys.


If you notice how the variable are set, it is self explanatory. If you alter the definitions you will not get the desired results. 
Fill in the the api keys for the respective apis and the api environment. 

**Note:**  Before you initialize any product, make sure you have entered the required apiKeys.

You should define variables as in the example below.

**From**

	return [
		"momo_api_collection_p_key"=>"momo",
		"momo_api_collection_s_key"=>"momo"
	];

**To**

	return [
		"momo_api_collection_p_key"=>"3f67974d9bc342c880cdfgb9c30998539",
		"momo_api_collection_s_key"=>"5hgj7974d9bc342c88060ab9c30954358"
	];
	

Variables with



> .....p_key  denote primary keys
> 
>  ....s_key denote secondary keys

Never exchange primary keys for secondary keys else you will never get the desired results.

Let's perform migrations

	php artisan migrate -v
	
We are now done setting up the necessary configurations now when you  run the migrate command the tables required for this library to  run well will be created.

## Examples ##

The following code snippets will walk through the process of working this php laravel library but conventions may differ according to your coding 
practices.

**Before we begin,**

we assume you were successful in the installation steps provided above. 
You should cross check to make sure you have all components installed.

We also assume that you have good knowledge working with laravel and the command line.

## Product Initialisation ##

**Caution:** Never initialize all of your products in the same controller or file. This is because every time you initialize a product,
the data being fetched adds a considerable time on the page load time. This library has been developed to ease your integration not to draw away your project users.

To get started, let's create a sample controller and name it **CollectionsController**. In terminal or command prompt, enter the following artisan command.

	$php artisan make:controller CollectionsController
	
Press enter/return button to execute the command

You will find the generated file in


	 app>Http>Controllers>CollectionsController.php

When you open this file in your editor you will find the following code

	<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;

	class CollectionsController extends Controller
	{
   		 //
	}

Let's add a constructor and our callback to the controller 


	<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;
	use Momo;
	
	class CollectionsController extends Controller
	{
		protected $momoCollection;

    		public function __construct()
    		{
    			$this->momoCollection=Momo::initCollections();
    		}

    		public function index()
    		{
    			//checks collection balance

    			$balance=$this->momoCollection->requestBalance();

    			//for presantation let's just display the balance

    			echo "<pre>";

    			var_dump($balance);
    		}

	}

Now let's add a route to our project. Open

	routes>web.php
	
Add

	Route::get('/collections/balance', 'CollectionsController@index');
	
	
Open the route you have created in your browser. 

To our controller **CollectionsController**, lets add another method **paynow**

I have assumed that the user has are selected the products in the cart and generated the invoice.
Now by pressing the PayNow button  to make the payment, we shall also create a route in our web.php file that call the paynow callback.

	Route::post('/collections/paynow','CollectionsController@paynow');
	

In CollectionsController.php  add


	............
	
	use App\Invoice;
	use LaMomo\MomoApp\Models\RequestToPay;
	
	//............
	
	public function paynow(Request $request) {
	
    		$invoice=Invoice::find($request->input('id'));

    		$requestToPay=new RequestToPay($invoice->id,$invoice->total,$invoice->payment->partyId,$invoice->payment->partyIdType,'Pay invoice no. '.$invoice->invoice_number,'Invoice payment');
    		$response =$this->momoCollection->requestToPay($requestToPay,'{callback url}');

    		if ($response->isAccepted()) {
    			$invoice->refrenceId=$response->getReferenceId();
    			$invoice->save();
    			return redirect('/invoice')->with('status','Invoice submitted please approve your payment');
    		}

    		return redirect('/invoice')->with('warning','Error submitting invoice try again');

    }
    
	//..........

Add invoice route to web.php

	Route::get('/invoice/{id}','CollectionsController@invoice');
	

Let's add the invoice callback to our controller

	//.........................
		
	//......................


	
**Nice time coding**

Regards

Linus Nowomukama

[mailto:ugsalons@gmail.com](mailto:ugsalons@gmail.com "Send Email")

[tel:+256783198167](tel:+256783198167 "Call me")

[tel:+256751921465](tel:+256751921465 "Call or Watsapp")








	
