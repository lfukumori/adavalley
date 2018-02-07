<?php

namespace Tests\Feature\Temps;

use App\Temperature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogTemperatureToFileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_log_integer_temperatures_to_a_file()
    {
        $temp = new Temperature;
        $temp->degrees = 34;
        $temp->scale = 'F';

        $this->post('/temperature', $temp->toArray());

        $this->assertDatabaseHas('temperatures', [
            'id' => 1,
            'degrees' => $temp->degrees,
            'scale' => $temp->scale
        ]);
    }
}
