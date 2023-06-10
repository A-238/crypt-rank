<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * class DigitalCurrencyRanking
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency query()
 */
class DigitalCurrencyRanking extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'digital_currency_id',
        'ranking',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'digital_currency_id' => 'integer',
        'ranking' => 'integer',
    ];
}
