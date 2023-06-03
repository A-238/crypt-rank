<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Gateway\CoinMarketCapGateway;
use Illuminate\Console\Command;

class SampleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sample-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '全仮想通貨時価総額ランキングを取得する';

    private CoinMarketCapGateway $coinMarketCapGateway;

    public function __construct(CoinMarketCapGateway $coinMarketCapGateway)
    {
        parent::__construct();
        $this->coinMarketCapGateway = $coinMarketCapGateway;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // docker compose exec app php artisan app:sample-command
        $res = $this->coinMarketCapGateway->get('/v1/cryptocurrency/listings/latest', [
            'start' => 1,
            'limit' => 10,
        ]);

        // TODO: 現在はログ出力のみだが、テーブルへ保存する処理を実装する予定
        logger()->debug($res);
    }
}
