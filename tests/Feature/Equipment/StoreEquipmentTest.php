<?php

namespace Tests\Feature\Equipment;

use App\Equipment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreEquipmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_users_can_move_equipment_to_storage()
    {
        $this->signIn();
        
        $equipment = create(Equipment::class);

        $this->delete($equipment->path());

        $this->assertSoftDeleted('equipment', $equipment->toArray());
    }
}
