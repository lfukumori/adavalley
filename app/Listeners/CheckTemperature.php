<?php

namespace App\Listeners;

use App\TemperatureMonitor;
use App\Events\TemperatureLogged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckTemperature
{
    /**
     * Handle the event.
     *
     * @param  TemperatureLogged  $event
     * @return void
     */
    public function handle(TemperatureLogged $event)
    {
        $monitor = TemperatureMonitor::init($event->temp);
 
        $monitor->execute();
    }
}
