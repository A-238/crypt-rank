<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\UseCases\MarketCapitalizationRanking\FetchCommandUseCase;
use Illuminate\Console\Command;
use Illuminate\Http\Client\RequestException;

class FetchMarketCapitalizationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-market-capitalization-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '暗号通貨時価総額情報を取得する';

    private FetchCommandUseCase $fetchCommandUseCase;

    public function __construct(FetchCommandUseCase $fetchCommandUseCase)
    {
        parent::__construct();
        $this->fetchCommandUseCase = $fetchCommandUseCase;
    }

    /**
     * Execute the console command.
     * $ docker compose exec app php artisan app:fetch-market-capitalization-command
     */
    public function handle(): void
    {
        try {
            $this->fetchCommandUseCase->handle();
        } catch (RequestException) {
            logger()->warning('Fetch Market Capitalization Command ERROR!!');
        }
    }
}
