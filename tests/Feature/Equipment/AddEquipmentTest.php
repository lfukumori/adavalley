<?php

namespace Tests\Feature\Equipment;

use App\Equipment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddEquipmentTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function only_authenticated_users_can_add_equipment()
    {
        $this->signIn();

        $equipment = make(Equipment::class);

        $this->post('/equipment', $equipment->toArray());

        $this->assertDatabaseHas('equipment', $equipment->toArray());

    }
}
