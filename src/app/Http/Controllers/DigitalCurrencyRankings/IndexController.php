<?php

declare(strict_types=1);

namespace App\Http\Controllers\DigitalCurrencyRankings;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
    }


    public function __invoke()
    {
        return 'Hello IndexController';
    }
}
