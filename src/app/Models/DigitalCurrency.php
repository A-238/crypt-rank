<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * class DigitalCurrency
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency query()
 * @property int $id
 * @property string $name 通貨名
 * @property string $symbol シンボル
 * @property float $price 市場価格
 * @property float $market_cap 時価総額
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency whereMarketCap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency whereSymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Database\Factories\DigitalCurrencyFactory factory(...$parameters)
 */
class DigitalCurrency extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'symbol',
        'price',
        'market_cap',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name' => 'string',
        'symbol' => 'string',
        'price' => 'double',
        'market_cap' => 'double',
    ];

    /**
     * @return HasMany
     */
    public function digitalCurrencyRankings(): HasMany
    {
        return $this->hasMany(DigitalCurrencyRanking::class);
    }
}
