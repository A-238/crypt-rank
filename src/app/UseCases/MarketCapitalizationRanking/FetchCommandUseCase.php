<?php

namespace App\UseCases\MarketCapitalizationRanking;

use App\Gateway\CoinMarketCapGateway;
use App\Models\DigitalCurrency;
use App\Models\DigitalCurrencyRanking;
use App\Models\DigitalCurrencyRankingHistory;
use App\UseCases\UseCaseInterface;
use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\DB;

class FetchCommandUseCase implements UseCaseInterface
{
    private CoinMarketCapGateway $coinMarketCapGateway;

    private DigitalCurrency $digitalCurrency;

    private DigitalCurrencyRanking $digitalCurrencyRanking;

    private DigitalCurrencyRankingHistory $digitalCurrencyRankingHistory;

    public function __construct(
        CoinMarketCapGateway $coinMarketCapGateway,
        DigitalCurrency $digitalCurrency,
        DigitalCurrencyRanking $digitalCurrencyRanking,
        DigitalCurrencyRankingHistory $digitalCurrencyRankingHistory
    )
    {
        $this->coinMarketCapGateway = $coinMarketCapGateway;
        $this->digitalCurrency = $digitalCurrency;
        $this->digitalCurrencyRanking = $digitalCurrencyRanking;
        $this->digitalCurrencyRankingHistory = $digitalCurrencyRankingHistory;
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

        $this->digitalCurrencyRanking->newQuery()->delete();

        // TODO: トランザクションかける
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
                    ]
                );

                // TODO: もっとすっきりかけないか？一発で取得できるメソッドなどないか
                $lastInsertOrUpdateId = DB::getPdo()->lastInsertId();
                if (!$lastInsertOrUpdateId) {
                    $lastInsertOrUpdateId = $this->digitalCurrency
                        ->newQuery()
                        ->select('id')
                        ->where(['symbol' => $digitalCurrency->symbol])
                        ->get()->first()->id;
                }

                $this->digitalCurrencyRanking->newQuery()->insert(
                    [
                        'digital_currency_id' => $lastInsertOrUpdateId,
                        'ranking' => $digitalCurrency->cmc_rank,
                    ]
                );

                $today = Carbon::today();
                // TODO: 日付で全削除しておく？

                $this->digitalCurrencyRankingHistory->newQuery()->insert(
                    [
                        'digital_currency_id' => $lastInsertOrUpdateId,
                        'price' => $digitalCurrency->quote->USD->price,
                        'market_cap' => $digitalCurrency->quote->USD->market_cap,
                        'ranking' => $digitalCurrency->cmc_rank,
                        'fetched_date' => $today,
                    ]
                );
            }
        });
    }
}
