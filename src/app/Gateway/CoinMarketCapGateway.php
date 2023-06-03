<?php

declare(strict_types=1);

namespace Gateway;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\ArrayShape;

class CoinMarketCapGateway
{
    /** @var PendingRequest */
    private PendingRequest $http;

    /** @var string */
    private string $coinMarketCapUrl;

    public function __construct()
    {
        $this->coinMarketCapUrl = config('coinmarketcap.api_url');
        $this->http = Http::acceptJson()->withHeaders($this->headers());
    }

    /**
     * @return array
     */
    #[ArrayShape(['X-CMC_PRO_API_KEY' => "string"])] private function headers(): array
    {
        return [
            'X-CMC_PRO_API_KEY' => config('coinmarketcap.api_key'),
        ];
    }

    /**
     * @param string $endpoint
     * @param array $params
     * @return Response
     * @throws RequestException
     */
    public function get(string $endpoint, array $params = []): Response
    {
        $response = $this->http->get($this->coinMarketCapUrl . $endpoint, $params);

        return $this->handle($response, $params);
    }

    /**
     * レスポンスのエラーハンドリングを行う。レスポンスが400以上の場合は、リクエストパラメータをログに残して例外を投げる。
     *
     * @param Response $response
     * @param array $params
     * @return Response
     * @throws RequestException
     */
    private function handle(Response $response, array $params): Response
    {
        try {
            if ($response->successful()) {
                Log::info('API Request Success', $params);
                Log::info('API Response', $response->json());
                return $response;
            }
            $response->throw();
        } catch (RequestException $e) {
            Log::error('API Request Error', $params);
            Log::error('API Response', $response->json());
            throw $e;
        }

        throw new \LogicException();
    }
}
