<?php
namespace LaMomo\MomoApp\Traits;

trait MomoConsole{
	protected $bar;
	protected function showWelcome(){
        $this->line('Welcome to Laravel Momo Api package designed by Linworld Tech-Solutions');
    }
    protected function showBar(){
    	$this->bar=$this->output->createProgressBar(100);
    	$this->bar->start(1);
    	for ($i=0; $i <99 ; $i++) { 
    		$this->line('Now at: '.$i);
    		$this->bar->advance();
    		sleep(1);
    	}
    	$this->bar->finish();
    }
     protected function changeEnv($data = array()){
        if(count($data) > 0){

            // Read .env-file
            $this->info('Updating .env file');
            $env = file_get_contents(base_path() . '/.env');

            // Split string on every " " and write into array
            $env = preg_split('/\s+/', $env);;

            // Loop through given data
            foreach((array)$data as $key => $value){

                // Loop through .env-data
                foreach($env as $env_key => $env_value){

                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if($entry[0] == $key){
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                        
                    }
                }
            }

            // Turn the array back to an String
            $env = implode("\n", $env);

            // And overwrite the .env with the new data
            file_put_contents(base_path() . '/.env', $env);
            
            return true;
        } else {
            return false;
        }
    }
}