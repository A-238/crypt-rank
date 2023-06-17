<?php

declare(strict_types=1);

namespace App\Http\Controllers\DigitalCurrencyRankings;

use App\Http\Controllers\Controller;
use App\Http\Requests\DigitalCurrencyRankings\IndexRequest;
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
     * 取得するランキングの最大数
     * @var int
     */
    private int $initLimit = 100;

    /**
     * 昇順または降順
     * @var string
     */
    private string $initSort = 'desc';

    /**
     * @param IndexUseCase $indexUseCase
     */
    public function __construct(IndexUseCase $indexUseCase)
    {
        $this->indexUseCase = $indexUseCase;
    }

    /**
     * @param IndexRequest $request
     * @return ResourceCollection
     */
    public function __invoke(IndexRequest $request): ResourceCollection
    {
        $limit = $request->input('limit') ? $request->input('limit') : $this->initLimit;
        $sort = $request->input('sort') ? $request->input('sort') : $this->initSort;

        $digitalCurrencyRankings = $this->indexUseCase->handle($limit, $sort);
        return IndexResource::collection($digitalCurrencyRankings);
    }
}
