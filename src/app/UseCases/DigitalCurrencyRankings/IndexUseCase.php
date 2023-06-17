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
     * @param int|null $limit
     * @param string|null $sort
     * @return Collection
     */
    public function handle(?int $limit, ?string $sort): Collection
    {
        return $this->digitalCurrencyRankingsFetcher->fetch($limit, $sort);
    }
}
