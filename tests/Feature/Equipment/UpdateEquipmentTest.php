<?php

namespace Tests\Feature\Equipment;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Equipment;

class UpdateEquipmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_update_equipment_details()
    {
        $this->signIn();

        $equipment = create(Equipment::class);
        $updatedName = 'Updated Name';

        $this->patch("/equipment/{$equipment->id}", ['name' => $updatedName]);

        $this->assertDatabaseHas('equipment', $equipment->fresh()->toArray());
    }
}
