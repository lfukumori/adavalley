<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Temperature;

class LogTemperatures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adavalley:logtemps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Logs room temperatures to database';

    /**
     * A list of all rooms that need temperatures logged.
     * 
     * @var array
     */
    private $rooms = ['cooler', 'freezer'];

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
        foreach ($this->rooms as $room) {
            $schedule->exec("mosquitto -h 192.168.1.12 -p 1883 -t temperatures/{$room} -n");
        }
    }
}
