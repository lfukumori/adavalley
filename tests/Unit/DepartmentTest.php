<?php

namespace Tests\Unit;

use App\Department;
use App\Equipment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DepartmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A department can have many equipment associated with it.
     */
    public function test_equipment()
    {
        $department = create(Department::class);
        $equipment = create(Equipment::class, ['department_id' => $department->id], 2);

        $this->assertInstanceOf(Equipment::class, $department->equipment->first());
        $this->assertInstanceOf(Equipment::class, $department->equipment->last());
    }
}
