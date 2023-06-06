<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * class DigitalCurrency
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DigitalCurrency query()
 */
class DigitalCurrency extends Model
{
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
        'market_cap_rank',
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
        'market_cap_rank' => 'integer',
    ];
}
