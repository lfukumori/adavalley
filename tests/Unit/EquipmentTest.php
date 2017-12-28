<?php

namespace Tests\Unit;

use App\Equipment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EquipmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Single piece of Equipment persisted to database.
     *
     * @var \App\Equipment
     */
    protected $equipment;

    /**
     * Set up test enviroment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->equipment = create(Equipment::class);
    }
    
    /** @test */
    public function a_peice_of_equipment_knows_its_url_route_path()
    {
        $urlRoute = "/equipment/{$this->equipment->id}";

        $this->assertEquals($urlRoute, $this->equipment->path());
    }
}
