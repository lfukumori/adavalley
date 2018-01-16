<?php

namespace Tests\Unit;

use App\Department;
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
    public function test_path()
    {
        $urlRoute = "/equipment/{$this->equipment->id}";

        $this->assertEquals($urlRoute, $this->equipment->path());
    }

    /** 
     * Move equipment out of production to storage.
     */
    public function test_store()
    {
        $this->equipment->store();

        $this->assertSoftDeleted('equipment', $this->equipment->toArray());
    }

    /**
     * A piece of equipment belongs to a department
     */
    public function test_department()
    {
        $department = new Department(['name' => 'Room1']);

        $this->equipment->department()->associate($department);

        $this->assertInstanceOf(Department::class, $this->equipment->department);
    }
}
