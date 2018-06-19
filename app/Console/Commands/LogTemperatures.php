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
        $this->logTemp('cooler');

        $this->logTemp('freezer');
    }

    private function logTemp($room)
    {
        $data = $this->getData($room);

        $temp = new Temperature;
        $temp->degrees = $data['degrees'];
        $temp->scale = $data['scale'];
        $temp->room = $data['room'];

        if (! $temp->save()) {
            return $this->logTemp($room);
        }

        return true;
    }

    private function getData($room)
    {
        do {
            $data = json_decode(
                str_replace("'", '"', file_get_contents("http://192.168.1.170/{$room}")), 
                true
            );
        } while ($data['status'] != 200);
        
        return $data;
    }
}
