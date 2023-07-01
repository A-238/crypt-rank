<?php

declare(strict_types=1);

namespace Services\DigitalCurrencies;

use App\Services\DigitalCurrencies\DigitalCurrenciesReceiver;
use stdClass;
use Tests\TestCase;

class DigitalCurrenciesReceiverTest extends TestCase
{
    /**
     * @var DigitalCurrenciesReceiver
     */
    private DigitalCurrenciesReceiver $digitalCurrenciesReceiver;

    public function setUp(): void
    {
        parent::setUp();
        $this->digitalCurrenciesReceiver = app()->make(DigitalCurrenciesReceiver::class);
    }

    /**
     * @test
     */
    public function CoinMarketCapAPIの暗合通貨データがフォーマットされることを検証する(): void
    {
        $formatted = $this->digitalCurrenciesReceiver->set($this->coinMarketCapDigitalCurrency())->format()->get();

        $this->assertSame(collect([
            'symbol' => 'BTC',
            'name' => 'Bitcoin',
            'price' => 30516.85086273061,
            'market_cap' => 592539589831.4678,
        ])->toArray(), $formatted->toArray());
    }

    /**
     * @return stdClass
     */
    private function coinMarketCapDigitalCurrency(): stdClass
    {
        $json = <<<JSON
{
    "id": 1,
    "name": "Bitcoin",
    "symbol": "BTC",
    "slug": "bitcoin",
    "num_market_pairs": 10261,
    "date_added": "2010-07-13T00:00:00.000Z",
    "tags": [
        "mineable",
        "pow",
        "sha-256",
        "store-of-value",
        "state-channel",
        "coinbase-ventures-portfolio",
        "three-arrows-capital-portfolio",
        "polychain-capital-portfolio",
        "binance-labs-portfolio",
        "blockchain-capital-portfolio",
        "boostvc-portfolio",
        "cms-holdings-portfolio",
        "dcg-portfolio",
        "dragonfly-capital-portfolio",
        "electric-capital-portfolio",
        "fabric-ventures-portfolio",
        "framework-ventures-portfolio",
        "galaxy-digital-portfolio",
        "huobi-capital-portfolio",
        "alameda-research-portfolio",
        "a16z-portfolio",
        "1confirmation-portfolio",
        "winklevoss-capital-portfolio",
        "usv-portfolio",
        "placeholder-ventures-portfolio",
        "pantera-capital-portfolio",
        "multicoin-capital-portfolio",
        "paradigm-portfolio",
        "bitcoin-ecosystem"
    ],
    "max_supply": 21000000,
    "circulating_supply": 19416800,
    "total_supply": 19416800,
    "infinite_supply": false,
    "platform": null,
    "cmc_rank": 1,
    "self_reported_circulating_supply": null,
    "self_reported_market_cap": null,
    "tvl_ratio": null,
    "last_updated": "2023-07-01T12:03:00.000Z",
    "quote": {
        "USD": {
            "price": 30516.85086273061,
            "volume_24h": 21221718694.41687,
            "volume_change_24h": 28.8653,
            "percent_change_1h": 0.12896199,
            "percent_change_24h": -1.34202989,
            "percent_change_7d": -0.5597311,
            "percent_change_30d": 13.49950667,
            "percent_change_60d": 8.6818311,
            "percent_change_90d": 7.63452649,
            "market_cap": 592539589831.4678,
            "market_cap_dominance": 49.5729,
            "fully_diluted_market_cap": 640853868117.34,
            "tvl": null,
            "last_updated": "2023-07-01T12:03:00.000Z"
        }
    }
}
JSON;
        return json_decode($json);
    }
}
