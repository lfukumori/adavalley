<?php

namespace App;

use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;

class TemperatureMonitor extends Model
{
    private $maxMinutes = 30;
    protected $guarded = [];
    public $temp;

    public function execute() 
    {
        if ($this->temp->isOutOfRange()) {
            $this->watch();

            return true;
        }

        if (! $this->dismissed) $this->dismiss();
    }

    public static function init(Temperature $temp)
    {
        return self::getMonitor($temp);
    }

    /**
     * Gets the old monitor or creates a new one.
     *
     * @return \App\TemperatureMonitor
     */
    public static function getMonitor($temp)
    {
        $monitor = TemperatureMonitor::where([
            ['room', $temp->room],
            ['scale', $temp->scale],
        ])->latest()->first();

        if (is_null($monitor) || $monitor->dismissed) {
            $monitor = new TemperatureMonitor([
                'degrees' => $temp->degrees,
                'scale' => $temp->scale,
                'room' => $temp->room,
            ]);

            $monitor->temp = $temp;
            
            if ($monitor->temp->isOutOfRange()) {
                $monitor->save();
            } else {
                $monitor->dismissed = true;
            }

            return $monitor;
        }

        $monitor->temp = $temp;

        return $monitor;
    }

    /**
     * Send a temperature notification.
     *
     * @return void
     */
    public function notify()
    {
        $employees = [
            'brian' => 'bdbriandupont@gmail.com'
        ];

        foreach ($employees as $name => $email) {
            Mail::send('emails.alert-room-temp', ['monitor' => $this, 'name' => $name], function ($message) use($email) {
                $message->from('brian@adavalley.com', 'Temp Alert');
                $message->to($email);
            });
        }
    }

    /**
     * Stops the temperature monitor from watching temperature.
     * 
     * @param string  $by
     * 
     * @return boolean
     */
    public function dismiss($by = 'temperature')
    {
        $this->dismissed = true;
        $this->dismissed_by = $by;

        if (! $this->save()) return false;

        return true;
    }

    /**
     * Will continue to monitor the rooms temperature and notify employees if temp is out of range for to long.
     * 
     * @return boolean
     */
    public function watch()
    {
        $this->minutes++;
        $this->degrees = $this->temp->degrees;

        // send notification?
        if ($this->minutes > $this->maxMinutes && ! $this->dismissed) $this->notify();

        if (!$this->save()) return false;

        return true;
    }
}
