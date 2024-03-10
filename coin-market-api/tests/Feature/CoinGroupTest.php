<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CoinGroupTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $response = $this->get('/api/coin-groups');

        $response->assertStatus(200);
    }

    public function test_create()
    {
        $data = [
            'coin_id' => 1,
            'group_id' => 1,
        ];

        $response = $this->postJson('/api/coin-groups', $data);

        $response->assertStatus(201);
    }

    public function test_read()
    {
        $coinGroup = CoinGroup::factory()->create();

        $response = $this->get('/api/coin-groups/' . $coinGroup->id);

        $response->assertStatus(200);
    }

    public function test_update()
    {
        $coinGroup = CoinGroup::factory()->create();
        $data = [
            'coin_id' => 2,
            'group_id' => 2,
        ];

        $response = $this->putJson('/api/coin-groups/' . $coinGroup->id, $data);

        $response->assertStatus(200);
    }

    public function test_delete()
    {
        $coinGroup = CoinGroup::factory()->create();

        $response = $this->delete('/api/coin-groups/' . $coinGroup->group_id . '/' . $coinGroup->coin_id);

        $response->assertStatus(200);
    }

    public function test_readByGroupId()
    {
        $groupId = 1;
        $response = $this->get('/api/coin-groups/read-by-group/' . $groupId);

        $response->assertStatus(200);
    }
}
