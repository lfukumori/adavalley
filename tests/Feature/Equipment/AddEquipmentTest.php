<?php

namespace Tests\Feature\Equipment;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Equipment;

class AddEquipmentTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function an_authenticated_user_can_create_equipment()
    {
        $this->signIn();

        $equipment = make(Equipment::class);

        $this->post('/equipment', $equipment->toArray());

        $this->assertDatabaseHas('equipment', [
            'name' => $equipment->name,
            'brand' => $equipment->brand,
            'model' => $equipment->model
        ]);
    }
}
