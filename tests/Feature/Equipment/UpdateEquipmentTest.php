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
        $updatedName = 'Updated Name';
        $equipment = create(Equipment::class);

        $this->signIn();

        $this->patch("/equipment/{$equipment->id}", ['name' => $updatedName]);

        $this->assertDatabaseHas('equipment', ['name' => $updatedName]);
    }
}
