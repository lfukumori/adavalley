<?php

namespace Tests\Feature\Equipment;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Equipment;

class UpdateEquipmentTest extends TestCase
{
    use RefreshDatabase;

    protected $equipment;

    public function setUp()
    {
        parent::setUp();
        $this->equipment = create(Equipment::class);
    }

    /** @test */
    public function only_authorized_users_can_update_equipment_details()
    {
        $response = $this->patch($this->equipment->path(), ['brand' => 'some brand']);

        $response->assertRedirect('/login');
    }
}
