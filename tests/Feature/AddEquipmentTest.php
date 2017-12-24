<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_user_can_create_equipment()
    {
        $equipment = make(Equipment::class);

        $this->post('/equipment', $equipment->toArray());

        $this->assertDatabaseHas('equipment', [
            'name' => $equipment->name,
            'brand' => $equipment->brand,
            'model' => $equipment->model,
            'serial_number' => $equipment->serial_number,
            'weight' => $equipment->weight,
            'description' => $equipment->description,
            'purchase_value' => $equipment->purchase_value,
            'purchase_date' => $equipment->purchase_date
        ]);
    }
}
