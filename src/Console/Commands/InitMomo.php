<?php

namespace LaMomo\MomoApp\Console\Commands;

use Illuminate\Console\Command;
use LaMomo\MomoApp\Traits\MomoConsole;

class InitMomo extends Command
{
    use MomoConsole;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'momo:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialises the momo api integration provided by linlak\\laravelmomoapi laravel package';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // line, info, comment, question, error,table
         $this->showWelcome();
         // $this->changeEnv(["MOMO_COLLECTIONS_P_KEY"=>"","MOMO_COLLECTIONS_S_KEY"=>""]);
         
    }

    
}
