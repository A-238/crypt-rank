<?php

declare(strict_types=1);

namespace App\Http\Controllers\DigitalCurrencyRankings;

use App\Http\Controllers\Controller;
use App\Http\Resources\DigitalCurrencyRankings\IndexResource;
use App\UseCases\DigitalCurrencyRankings\IndexUseCase;
use Illuminate\Http\Resources\Json\ResourceCollection;

class IndexController extends Controller
{
    /**
     * @var IndexUseCase
     */
    private IndexUseCase $indexUseCase;

    /**
     * @param IndexUseCase $indexUseCase
     */
    public function __construct(IndexUseCase $indexUseCase)
    {
        $this->indexUseCase = $indexUseCase;
    }

    /**
     * @return ResourceCollection
     */
    public function __invoke(): ResourceCollection
    {
        $digitalCurrencyRankings = $this->indexUseCase->handle();
        return IndexResource::collection($digitalCurrencyRankings);
    }
}
