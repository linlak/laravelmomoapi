<?php

namespace LaMomo\MomoApp\Console\Commands;

use Illuminate\Console\Command;
use LaMomo\MomoApp\Traits\MomoConsole;
use LaMomo\MomoApp\Models\AccessToken;

class CleanTokens extends Command
{
    use MomoConsole;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'momo:token-clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes expired api tokens';

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
        $tokens = AccessToken::where('updated_at', '<', now()->subHour());
        if ($tokens->count()) {
            foreach ($tokens as $token) {
                $token->delete();
            }
        }
        // echo (now()->subHour());
    }
}
