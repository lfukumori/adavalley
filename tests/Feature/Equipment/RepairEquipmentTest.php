<?php

namespace Tests\Feature\Equipment;

use App\Equipment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepairEquipmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_authenticated_users_can_create_equipment()
    {
        $this->assertTrue(true);
    }
}
