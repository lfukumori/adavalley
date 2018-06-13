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
    protected $description = 'Logs room temperatures to mysql database';

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
        $data = file_get_contents('http://192.168.1.170/cooler');
        $data = str_replace("'", '"', $data);
        $data = json_decode($data, true);
        if ($data['status'] == 200) {
            $temp = new Temperature;
            $temp->degrees = $data['degrees'];
            $temp->scale = $data['scale'];
            $temp->room = $data['room'];
            $temp->save();
        }
        
        $data = file_get_contents('http://192.168.1.170/freezer');
        $data = str_replace("'", '"', $data);
        $data = json_decode($data, true);
        if ($data['status'] == 200) {
            $temp = new Temperature;
            $temp->degrees = $data['degrees'];
            $temp->scale = $data['scale'];
            $temp->room = $data['room'];
            $temp->save();
        }
    }
}
