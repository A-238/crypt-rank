<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * class DigitalCurrencyRanking
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency query()
 * @property int $id
 * @property int $digital_currency_id
 * @property int $ranking 時価総額ランキング
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrencyRanking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrencyRanking whereDigitalCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrencyRanking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrencyRanking whereRanking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrencyRanking whereUpdatedAt($value)
 * @mixin Eloquent
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

    /**
     * @return BelongsTo
     */
    public function digitalCurrency(): BelongsTo
    {
        return $this->belongsTo(DigitalCurrency::class);
    }
}
