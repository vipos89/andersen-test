<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wallet;
use App\Repositories\WalletRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class TransactionsTest extends TestCase
{
    use WithFaker;

    public function testCreateTransaction(): void
    {
        factory(User::class, 10)
            ->create()
            ->each(static function ($user) {
                Wallet::create([
                    'user_id' => $user->id,
                    'satoshi_balance' => Wallet::START_SATOSHI_BALANCE
                ]);
            });
        $user = User::inRandomOrder()->first();
        $this->actingAs($user, 'api');
        $firstWallet = Wallet::where('user_id', $user->id)->first();
        $secondWallet = Wallet::where('user_id', '!=', $user->id)->first();
        $this->json('GET', 'api/transactions',
            [
                'from' => $firstWallet->id,
                'to' => $secondWallet->id,
                'amount' => $this->faker->randomDigit
            ],
            ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_OK);
    }
}
