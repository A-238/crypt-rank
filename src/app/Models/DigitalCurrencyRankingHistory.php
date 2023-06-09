<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * class DigitalCurrencyRankingHistory
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency query()
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
