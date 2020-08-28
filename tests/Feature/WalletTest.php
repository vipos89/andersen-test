<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wallet;
use App\Repositories\WalletRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class WalletTest extends TestCase
{
    use WithFaker;

    /**
     *Create new Wallet for user
     */
    public function testWalletCreation(): void
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

    /**
     * Test that user can't create more thant 10 wallets
     */
    public function testLimitWalletCreation(): void
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');
        $availableWalletCount = config('wallets.wallets_max_count', 10);
        for ($i = 0; $i < $availableWalletCount; $i++) {
            Wallet::create([
                'user_id' => $user->id,
                'satoshi_balance' => WalletRepository::START_SATOSHI_BALANCE
            ]);
        }
        $this->json('POST', 'api/wallets', [], ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    /**
     *Get Wallet info
     */
    public function testWalletInfo(): void
    {
        factory(User::class, 10)->create()->each(static function ($user) {
            Wallet::create([
                'user_id' => $user->id,
                'satoshi_balance' => WalletRepository::START_SATOSHI_BALANCE
            ]);
        });
        $user = User::inRandomOrder()->first();
        $wallet = Wallet::where('user_id', $user->id)->first();

        $this->actingAs($user, 'api');
        $this->json('GET', 'api/wallets/' . $wallet->id, [], ['Accept' => 'application/json'])
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

    /**
     *Test incorrect wallet address
     */
    public function testIncorrectWallet(): void
    {
        factory(User::class, 10)->create();
        $user = User::inRandomOrder()->first();
        $this->actingAs($user, 'api');
        $this->json('GET', 'api/wallets/' . $this->faker->uuid, [], ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }

}
