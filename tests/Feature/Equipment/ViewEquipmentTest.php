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
        $equipment1 = create(Equipment::class);
        $equipment2 = create(Equipment::class);
        $equipment3 = create(Equipment::class);

        $this->get('/equipment')
            ->assertSee($equipment1->name)
            ->assertSee($equipment2->name)
            ->assertSee($equipment3->name);
    }
}
