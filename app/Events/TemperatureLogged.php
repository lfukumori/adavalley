<?php

namespace App\Events;

use App\Temperature;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TemperatureLogged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $temp;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Temperature $temp)
    {
        $this->temp = $temp;
    }
}
