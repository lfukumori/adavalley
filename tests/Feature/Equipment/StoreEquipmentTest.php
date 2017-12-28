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
        $equipment = create(Equipment::class);

        $this->signIn();

        $this->delete($equipment->path());

        $this->assertDatabaseMissing('equipment', ['id' => $equipment->id]);
    }
}
