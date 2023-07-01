<?php

namespace App\Services\DigitalCurrencies;

use Illuminate\Support\Collection;
use stdClass;

class DigitalCurrenciesReceiver
{
    /** @var stdClass */
    private stdClass $coinMarketCapDigitalCurrencies;

    /** @var Collection */
    private Collection $formatted;

    /**
     * CoinMarketCapから取得した暗合通貨データをプロパティにセット
     *
     * @param stdClass $coinMarketCapDigitalCurrencies
     * @return $this
     */
    public function set(stdClass $coinMarketCapDigitalCurrencies): self
    {
        $this->coinMarketCapDigitalCurrencies = $coinMarketCapDigitalCurrencies;
        return $this;
    }

    /**
     * digital_currenciesテーブルの形に会うようにフォーマット
     *
     * @return $this
     */
    public function format(): self
    {
        if (!isset($this->coinMarketCapDigitalCurrencies)) {
            throw new \LogicException('data not yet set.');
        }

        $this->formatted = collect([
            'symbol' => $this->coinMarketCapDigitalCurrencies->symbol,
            'name' => $this->coinMarketCapDigitalCurrencies->name,
            'price' => $this->coinMarketCapDigitalCurrencies->quote->USD->price,
            'market_cap' => $this->coinMarketCapDigitalCurrencies->quote->USD->market_cap,
        ]);

        return $this;
    }

    /**
     * フォーマットしたデータを取得
     *
     * @return Collection
     */
    public function get(): Collection
    {
        if (!isset($this->formatted)) {
            throw new \LogicException('data not yet formatted.');
        }

        return $this->formatted;
    }
}
