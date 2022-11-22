<?php

namespace Tests\Feature;

use App\Models\Neighbor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MessengerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $neighbor = Neighbor::first();


        $response = $this->get('/'.$neighbor->building_code.'/messenger');

        $response->assertStatus(302);
    }
}
