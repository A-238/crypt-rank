<?php

declare(strict_types=1);

namespace App\UseCases\DigitalCurrencyRankings;

use App\Services\DigitalCurrencyRankings\DigitalCurrencyRankingsFetcher;
use App\UseCases\UseCaseInterface;
use Illuminate\Support\Collection;

class IndexUseCase implements UseCaseInterface
{
    /**
     * @var DigitalCurrencyRankingsFetcher
     */
    private DigitalCurrencyRankingsFetcher $digitalCurrencyRankingsFetcher;

    /**
     * @param DigitalCurrencyRankingsFetcher $digitalCurrencyRankingsFetcher
     */
    public function __construct(DigitalCurrencyRankingsFetcher $digitalCurrencyRankingsFetcher)
    {
        $this->digitalCurrencyRankingsFetcher = $digitalCurrencyRankingsFetcher;
    }

    /**
     * @return Collection
     */
    public function handle(): Collection
    {
        return $this->digitalCurrencyRankingsFetcher->fetch();
    }
}
