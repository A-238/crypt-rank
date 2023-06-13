<?php

declare(strict_types=1);

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

    private Carbon $today;

    public function __construct(
        CoinMarketCapGateway $coinMarketCapGateway,
        DigitalCurrency $digitalCurrency,
        DigitalCurrencyRanking $digitalCurrencyRanking,
        DigitalCurrencyRankingHistory $digitalCurrencyRankingHistory
    ) {
        $this->coinMarketCapGateway = $coinMarketCapGateway;
        $this->digitalCurrency = $digitalCurrency;
        $this->digitalCurrencyRanking = $digitalCurrencyRanking;
        $this->digitalCurrencyRankingHistory = $digitalCurrencyRankingHistory;
    }

    /**
     * @param int $start
     * @param int $limit
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

        $this->today = Carbon::today();

        DB::transaction(function () use ($digitalCurrenciesResponse) {

            // 最新ランキングと実行日と同日のランキングを削除しておく
            $this->digitalCurrencyRanking->delete();
            $this->digitalCurrencyRankingHistory->where(['fetched_date' => $this->today])->delete();

            $digitalCurrenciesResponse->each(function (Response $response) {
                foreach ($response->object()->data as $digitalCurrency) {
                    $this->digitalCurrency->updateOrinsert(
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
                            ->select('id')
                            ->where(['symbol' => $digitalCurrency->symbol])
                            ->get()->first()->id;
                    }

                    $this->digitalCurrencyRanking->insert(
                        [
                            'digital_currency_id' => $lastInsertOrUpdateId,
                            'ranking' => $digitalCurrency->cmc_rank,
                        ]
                    );

                    $this->digitalCurrencyRankingHistory->insert(
                        [
                            'digital_currency_id' => $lastInsertOrUpdateId,
                            'price' => $digitalCurrency->quote->USD->price,
                            'market_cap' => $digitalCurrency->quote->USD->market_cap,
                            'ranking' => $digitalCurrency->cmc_rank,
                            'fetched_date' => $this->today,
                        ]
                    );
                }
            });
        });
    }
}
