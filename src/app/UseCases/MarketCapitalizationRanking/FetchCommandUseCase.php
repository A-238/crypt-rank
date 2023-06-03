<?php

namespace App\UseCases\MarketCapitalizationRanking;

use App\Gateway\CoinMarketCapGateway;
use App\UseCases\UseCaseInterface;
use Illuminate\Http\Client\RequestException;

class FetchCommandUseCase implements UseCaseInterface
{
    private CoinMarketCapGateway $coinMarketCapGateway;

    public function __construct(CoinMarketCapGateway $coinMarketCapGateway)
    {
        $this->coinMarketCapGateway = $coinMarketCapGateway;
    }

    /**
     * @return void
     * @throws RequestException
     */
    public function handle(): void
    {
        $res = $this->coinMarketCapGateway->get('/v1/cryptocurrency/listings/latest', [
            'start' => 1,
            'limit' => 10,
        ]);

        // TODO: 現在はログ出力のみだが、テーブルへ保存する処理を実装する予定
        logger()->debug($res);
    }
}
