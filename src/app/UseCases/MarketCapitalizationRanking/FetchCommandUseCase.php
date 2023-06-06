<?php

namespace App\UseCases\MarketCapitalizationRanking;

use App\Gateway\CoinMarketCapGateway;
use App\Models\DigitalCurrency;
use App\UseCases\UseCaseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;

class FetchCommandUseCase implements UseCaseInterface
{
    private CoinMarketCapGateway $coinMarketCapGateway;

    protected DigitalCurrency $digitalCurrency;

    public function __construct(
        CoinMarketCapGateway $coinMarketCapGateway,
        DigitalCurrency $digitalCurrency
    )
    {
        $this->coinMarketCapGateway = $coinMarketCapGateway;
        $this->digitalCurrency = $digitalCurrency;
    }

    /**
     * @return void
     * @throws RequestException
     */
    public function handle(int $start, int $limit): void
    {
        $digitalCurrenciesResponse = collect();
        $digitalCurrenciesResponse->push($this->coinMarketCapGateway->get('/v1/cryptocurrency/listings/latest', [
            'start' => $start,
            'limit' => $limit,
        ]));

        $digitalCurrenciesResponse->each(function (Response $response) {
            foreach ($response->object()->data as $digitalCurrency) {
                $this->digitalCurrency->newQuery()->updateOrinsert(
                    [
                        'symbol' => $digitalCurrency->symbol
                    ],
                    [
                        'name' => $digitalCurrency->name,
                        'symbol' => $digitalCurrency->symbol,
                        'price' => $digitalCurrency->quote->USD->price,
                        'market_cap' => $digitalCurrency->quote->USD->market_cap,
                        'market_cap_rank' => $digitalCurrency->cmc_rank,
                    ]
                );
            }
        });
    }
}
