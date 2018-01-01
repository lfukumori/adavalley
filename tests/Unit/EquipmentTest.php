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
    
    /** 
     * Equipment knows its url route path.
     */
    public function testPath()
    {
        $urlRoute = "/equipment/{$this->equipment->id}";

        $this->assertEquals($urlRoute, $this->equipment->path());
    }

    /** 
     * Move equipment out of production to storage.
     */
    public function testStore()
    {
        $this->equipment->store();

        $this->assertSoftDeleted('equipment', $this->equipment->toArray());
    }
}
