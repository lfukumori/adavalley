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
            $this->logTemp($room);
        }
    }

    private function logTemp($room)
    {
        $data = $this->getData($room);

        $temp = new Temperature([
            'degrees'   => $data['degrees'],
            'scale'     => $data['scale'],
            'room'      => $data['room'],
        ]);

        if (! $temp->save()) {
            return $this->logTemp($room);
        }

        return true;
    }

    private function getData($room)
    {
        do {
            usleep(500000); // 1/2 second

            $data = json_decode(
                str_replace("'", '"', file_get_contents("http://192.168.1.170/{$room}")),
                true
            );
        } while ($data['status'] != 200);

        return $data;
    }
}
