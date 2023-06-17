<?php

declare(strict_types=1);

namespace App\Http\Resources\DigitalCurrencyRankings;

use App\Models\DigitalCurrency;
use App\Models\DigitalCurrencyRanking;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property DigitalCurrency digitalCurrency
 * @mixin DigitalCurrencyRanking
 */
class IndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'rank' => $this->ranking,
            'symbol' => $this->digitalCurrency->symbol,
            'name' => $this->digitalCurrency->name,
            'marketCap' => $this->digitalCurrency->market_cap,
            'price' => $this->digitalCurrency->price,
        ];
    }
}
