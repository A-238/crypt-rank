<?php

declare(strict_types=1);

namespace Tests\Unit\Services\DigitalCurrencies;

use App\Models\DigitalCurrency;
use App\Services\DigitalCurrencies\DigitalCurrencyStore;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * docker compose exec app php artisan test tests/Unit/Services/DigitalCurrencies/DigitalCurrencyStoreTest.php
 */
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
    public function 既存のデータが存在しないときにupdateOrInsertを実行し、データが新規登録されることを検証する(): void
    {
        $this->digitalCurrencyStore->updateOrInsert(collect([
            'symbol' => 'TEST',
            'name' => 'test',
            'price' => 100,
            'market_cap' => 10000,
        ]));

        $this->assertDatabaseHas('digital_currencies', [
            'symbol' => 'TEST',
            'name' => 'test',
            'price' => 100,
            'market_cap' => 10000,
        ]);
    }

    /**
     * @test
     */
    public function 既存のデータが存在するときにupdateOrInsertを実行し、データが更新されることを検証する(): void
    {
        DigitalCurrency::factory()->create([
            'symbol' => 'TEST',
            'name' => 'test',
        ]);

        $this->digitalCurrencyStore->updateOrInsert(collect([
            'symbol' => 'TEST',
            'name' => 'test_update',
            'price' => 100,
            'market_cap' => 10000,
        ]));

        $this->assertSame(1, DigitalCurrency::count());

        $this->assertDatabaseHas('digital_currencies', [
            'symbol' => 'TEST',
            'name' => 'test_update',
            'price' => 100,
            'market_cap' => 10000,
        ]);
    }
}
