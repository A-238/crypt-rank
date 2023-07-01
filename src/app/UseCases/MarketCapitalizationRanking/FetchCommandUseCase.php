<?php

declare(strict_types=1);

namespace App\UseCases\MarketCapitalizationRanking;

use App\Gateway\CoinMarketCapGateway;
use App\Models\DigitalCurrency;
use App\Models\DigitalCurrencyRanking;
use App\Models\DigitalCurrencyRankingHistory;
use App\Services\DigitalCurrencies\DigitalCurrenciesReceiver;
use App\Services\DigitalCurrencies\DigitalCurrencyStore;
use App\UseCases\UseCaseInterface;
use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\DB;

class FetchCommandUseCase implements UseCaseInterface
{
    /**
     * @var CoinMarketCapGateway
     */
    private CoinMarketCapGateway $coinMarketCapGateway;

    /**
     * @var DigitalCurrency
     */
    private DigitalCurrency $digitalCurrency;

    /**
     * @var DigitalCurrencyRanking
     */
    private DigitalCurrencyRanking $digitalCurrencyRanking;

    /**
     * @var DigitalCurrencyRankingHistory
     */
    private DigitalCurrencyRankingHistory $digitalCurrencyRankingHistory;

    /**
     * @var DigitalCurrenciesReceiver
     */
    private DigitalCurrenciesReceiver $digitalCurrenciesReceiver;

    /**
     * @var DigitalCurrencyStore
     */
    private DigitalCurrencyStore $digitalCurrencyStore;

    /**
     * @var Carbon
     */
    private Carbon $today;

    /**
     * @param CoinMarketCapGateway $coinMarketCapGateway
     * @param DigitalCurrency $digitalCurrency
     * @param DigitalCurrencyRanking $digitalCurrencyRanking
     * @param DigitalCurrencyRankingHistory $digitalCurrencyRankingHistory
     * @param DigitalCurrenciesReceiver $digitalCurrenciesReceiver
     * @param DigitalCurrencyStore $digitalCurrencyStore
     */
    public function __construct(
        CoinMarketCapGateway $coinMarketCapGateway,
        DigitalCurrency $digitalCurrency,
        DigitalCurrencyRanking $digitalCurrencyRanking,
        DigitalCurrencyRankingHistory $digitalCurrencyRankingHistory,
        DigitalCurrenciesReceiver $digitalCurrenciesReceiver,
        DigitalCurrencyStore $digitalCurrencyStore
    ) {
        $this->coinMarketCapGateway = $coinMarketCapGateway;
        $this->digitalCurrency = $digitalCurrency;
        $this->digitalCurrencyRanking = $digitalCurrencyRanking;
        $this->digitalCurrencyRankingHistory = $digitalCurrencyRankingHistory;
        $this->digitalCurrenciesReceiver = $digitalCurrenciesReceiver;
        $this->digitalCurrencyStore = $digitalCurrencyStore;
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
            // FIXME: 最新ランキングの削除が効いていない
            $this->digitalCurrencyRanking->delete();
            $this->digitalCurrencyRankingHistory->where(['fetched_date' => $this->today])->delete();

            $digitalCurrenciesResponse->each(function (Response $response) {
                foreach ($response->object()->data as $digitalCurrency) {
                    $receiver = $this->digitalCurrenciesReceiver->set($digitalCurrency)->format();
                    $this->digitalCurrencyStore->updateOrinsert($receiver->get());

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
