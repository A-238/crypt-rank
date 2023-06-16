<?php

declare(strict_types=1);

namespace App\Services\DigitalCurrencyRankings;

use App\Models\DigitalCurrencyRanking;
use Illuminate\Support\Collection;

class DigitalCurrencyRankingsFetcher
{

    /**
     * @var DigitalCurrencyRanking
     */
    private DigitalCurrencyRanking $digitalCurrencyRanking;

    /**
     * @param DigitalCurrencyRanking $digitalCurrencyRanking
     */
    public function __construct(DigitalCurrencyRanking $digitalCurrencyRanking)
    {
        $this->digitalCurrencyRanking = $digitalCurrencyRanking;
    }

    /**
     * @return Collection
     */
    public function fetch(): Collection
    {
        return $this->digitalCurrencyRanking->orderBy('ranking')->get();
    }
}
