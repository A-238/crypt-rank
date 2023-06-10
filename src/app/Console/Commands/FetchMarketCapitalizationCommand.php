<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\UseCases\MarketCapitalizationRanking\FetchCommandUseCase;
use Illuminate\Console\Command;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FetchMarketCapitalizationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-market-capitalization {start} {limit}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '
    CoinMarketCapのAPIから暗号通貨時価総額情報を取得する
    {int start : 暗合通貨情報ランク順取得開始位置}
    {int limit : 取得上限}';

    private FetchCommandUseCase $fetchCommandUseCase;

    public function __construct(FetchCommandUseCase $fetchCommandUseCase)
    {
        parent::__construct();
        $this->fetchCommandUseCase = $fetchCommandUseCase;
    }

    /**
     * @return bool
     */
    private function validate(): bool
    {
        $validator = Validator::make(
            [
                'start' => $this->argument('start'),
                'limit' => $this->argument('limit'),
            ],
            [
                'start' => ['required', 'integer'],
                'limit' => ['required', 'integer'],
            ]
        );

        if ($validator->passes()) {
            return true;
        }

        $this->error('artisan app:fetch-market-capitalization validation error');

        foreach ($validator->errors()->all() as $error) {
            $this->error($error);
        }

        return false;
    }

    /**
     * Execute the console command.
     * $ docker compose exec app php artisan app:fetch-market-capitalization 1 10
     */
    public function handle(): void
    {
        if (!$this->validate()) {
            return;
        }

        $start = (int)$this->argument('start');
        $limit = (int)$this->argument('limit');

        Log::info('Fetch Market Capitalization Command start');

        try {
            $this->fetchCommandUseCase->handle($start, $limit);
        } catch (RequestException) {
            Log::warning('Fetch Market Capitalization Command ERROR!!');
        }

        Log::info('Fetch Market Capitalization Command end');
    }
}
