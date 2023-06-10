<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * class DigitalCurrencyRanking
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency query()
 * @property int $id
 * @property int $digital_currency_id
 * @property int $ranking 時価総額ランキング
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrencyRanking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrencyRanking whereDigitalCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrencyRanking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrencyRanking whereRanking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrencyRanking whereUpdatedAt($value)
 * @mixin \Eloquent
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
