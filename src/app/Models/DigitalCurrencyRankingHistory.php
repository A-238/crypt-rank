<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * class DigitalCurrencyRankingHistory
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency query()
 * @property int $id
 * @property int $digital_currency_id
 * @property float $price 市場価格
 * @property int $market_cap 時価総額
 * @property int $ranking 時価総額ランキング
 * @property Carbon $fetched_date データ取得日
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrencyRankingHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrencyRankingHistory whereDigitalCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrencyRankingHistory whereFetchedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrencyRankingHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrencyRankingHistory whereMarketCap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrencyRankingHistory wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrencyRankingHistory whereRanking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrencyRankingHistory whereUpdatedAt($value)
 * @mixin Eloquent
 */
class DigitalCurrencyRankingHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'digital_currency_id',
        'price',
        'market_cap',
        'ranking',
        'fetched_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'digital_currency_id' => 'integer',
        'price' => 'double',
        'market_cap' => 'integer',
        'ranking' => 'integer',
        'fetched_date' => 'date',
    ];
}
