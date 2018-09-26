<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RemoveTemperatureMonitors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all dismissed temperature monitors from database.';

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
        $output = DB::delete('DELETE FROM temperature_monitors WHERE dismissed = 1');
        return $output;
    }
}
