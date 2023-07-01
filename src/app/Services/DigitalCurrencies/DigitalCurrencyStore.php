<?php

declare(strict_types=1);

namespace App\Services\DigitalCurrencies;

use App\Models\DigitalCurrency;
use Illuminate\Support\Collection;

class DigitalCurrencyStore
{
    /**
     * @var DigitalCurrency
     */
    private DigitalCurrency $digitalCurrency;

    /**
     * @param DigitalCurrency $digitalCurrency
     */
    public function __construct(DigitalCurrency $digitalCurrency)
    {
        $this->digitalCurrency = $digitalCurrency;
    }

    /**
     * @param Collection $formattedDigitalCurrency
     * @return void
     */
    public function updateOrInsert(Collection $formattedDigitalCurrency): void
    {
        $this->digitalCurrency->updateOrInsert(
            [
                'symbol' => $formattedDigitalCurrency->get('symbol')
            ],
            [
                'name' => $formattedDigitalCurrency->get('name'),
                'symbol' => $formattedDigitalCurrency->get('symbol'),
                'price' => $formattedDigitalCurrency->get('price'),
                'market_cap' => $formattedDigitalCurrency->get('market_cap'),
            ]
        );
    }
}
