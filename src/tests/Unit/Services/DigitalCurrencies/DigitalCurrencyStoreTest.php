<?php

declare(strict_types=1);

namespace Tests\Unit\Services\DigitalCurrencies;

use App\Models\DigitalCurrency;
use App\Services\DigitalCurrencies\DigitalCurrencyStore;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DigitalCurrencyStoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var DigitalCurrencyStore
     */
    private DigitalCurrencyStore $digitalCurrencyStore;

    public function setUp(): void
    {
        parent::setUp();
        $this->digitalCurrencyStore = app()->make(DigitalCurrencyStore::class);
    }

    /**
     * @test
     */
    public function 既存のデータが存在しないときにupdateOrInsertを実行するとデータが新規登録され、登録されたデータのIDが返ることを検証する(): void
    {
        $digitalCurrencyId = $this->digitalCurrencyStore->updateOrInsert(collect([
            'symbol' => 'TEST',
            'name' => 'test',
            'price' => 100,
            'market_cap' => 10000,
        ]));

        $this->assertDatabaseHas('digital_currencies', [
            'id' => $digitalCurrencyId,
            'symbol' => 'TEST',
            'name' => 'test',
            'price' => 100,
            'market_cap' => 10000,
        ]);
    }

    /**
     * @test
     */
    public function 既存のデータが存在するときにupdateOrInsertを実行するとデータが更新され、更新されたデータのIDが返ることを検証する(): void
    {
        DigitalCurrency::factory()->create([
            'id' => 2,
            'symbol' => 'TEST',
            'name' => 'test',
        ]);

        $digitalCurrencyId = $this->digitalCurrencyStore->updateOrInsert(collect([
            'symbol' => 'TEST',
            'name' => 'test_update',
            'price' => 100,
            'market_cap' => 10000,
        ]));

        $this->assertSame(2, $digitalCurrencyId);
        $this->assertSame(1, DigitalCurrency::count());
        $this->assertDatabaseHas('digital_currencies', [
            'symbol' => 'TEST',
            'name' => 'test_update',
            'price' => 100,
            'market_cap' => 10000,
        ]);
    }
}
