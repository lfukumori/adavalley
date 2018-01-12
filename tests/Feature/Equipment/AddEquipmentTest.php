<?php

namespace Tests\Feature\Equipment;

use App\Equipment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddEquipmentTest extends TestCase
{
    use RefreshDatabase;

    protected $equipment;

    public function setUp()
    {
        parent::setUp();
        $this->equipment = create(Equipment::class);
    }
    
    /** @test */
    public function only_authorized_users_can_add_equipment()
    {
        $response = $this->post('/equipment', $this->equipment->toArray());

        $response->assertRedirect('/login');
    }

    /** @test */
    public function equipment_number_cannot_be_more_than_10_characters()
    {
        $this->signIn();

        $elevenDigits = 12345678901;

        $equipment = make(Equipment::class, ['number' => $elevenDigits]);

        $response = $this->post('/equipment', $equipment->toArray());

        $response->assertRedirect();
    }

    /** @test */
    public function equipment_number_must_be_unique()
    {
        $this->signIn();
        
        $duplicateNumber = $this->equipment->number;
 
        $equipmentTwo = make(Equipment::class, ['number' => $duplicateNumber]);

        $response = $this->post('/equipment', $equipmentTwo->toArray());

        $response->assertRedirect();
    }
}
