<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class WalletTest extends TestCase
{
    public function testWalletCreation()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');
        $this->json('POST', 'api/wallets', [], ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "message",
                "data" => [
                    "id",
                    "btc",
                    "usd"
                ]
            ]);
    }

    public function testLimitWalletCreation()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

    }
}
