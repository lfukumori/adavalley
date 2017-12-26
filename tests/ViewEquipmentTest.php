<?php

namespace Tests\Feature\Equipment;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Equipment;

class ViewEquipmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function any_user_can_view_a_list_of_all_equipment()
    {
        $equipment = factory(Equipment::class, 3)->create();
    
        $this->get('/equipment')
            ->assertSee($equipment->get(0)->name)
            ->assertSee($equipment->get(1)->name)
            ->assertSee($equipment->get(2)->name);
    }
}
