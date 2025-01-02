<?php

namespace Nikosid\Tipranks;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use InvalidArgumentException;

class Tipranks
{
    private string $baseUrl = 'https://mobile.tipranks.com';

    private Client $httpClient;

    public function __construct(string $email, string $password)
    {
        $this->httpClient = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'accept' => 'application/json,text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                'content-type' => 'application/json; charset=UTF-8',
                'accept-encoding' => 'gzip',
                'x-platform' => 'iphone',
                'user-agent' => 'TipRanksApp/17 CFNetwork/1390 Darwin/22.0.0',
                'accept-language' => 'en-US,en;q=0.9',
            ],
            'cookies' => true,
        ]);

        $this->login($email, $password);
    }

    private function request(string $method, string $endpoint, array $params = [], array $json = [], bool $isLogin = false): mixed
    {
        try {
            $options = [
                'query' => $params,
            ];

            if (! empty($json)) {
                $options['json'] = $json;
            }

            $response = $this->httpClient->request($method, $endpoint, $options);

            return $isLogin ? $response->getStatusCode() : json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            throw new \RuntimeException('Request failed: '.$e->getMessage());
        }
    }

    public function login(string $email, string $password): void
    {
        $statusCode = $this->request('POST', '/api/iOS/login2', [], [
            'email' => $email,
            'password' => $password,
        ], true);

        if ($statusCode !== 200) {
            throw new \RuntimeException("Failed to login, status code: $statusCode");
        }
    }

    public function getTopAnalystStocks(): array
    {
        return $this->request('GET', '/api/stocks/getMostRecommendedStocks/', [
            'benchmark' => '1',
            'period' => '3',
            'country' => 'US',
            'break' => time(),
        ]);
    }

    public function getTopSmartScoreStocks(): array
    {
        return $this->request('GET', '/api/Screener/GetStocks/', [
            'break' => time(),
            'country' => 'US',
            'page' => '1',
            'sortBy' => '1',
            'sortDir' => '2',
            'tipranksScore' => '5',
        ]);
    }

    public function getTopInsiderStocks(): array
    {
        return $this->request('GET', '/api/insiders/getTrendingStocks/', [
            'benchmark' => '1',
            'period' => '3',
            'country' => 'US',
            'break' => time(),
        ]);
    }

    public function getStockScreener(): array
    {
        return $this->request('GET', '/api/Screener/GetStocks/', [
            'break' => time(),
            'country' => 'US',
            'page' => '1',
            'sortBy' => '1',
            'sortDir' => '2',
        ]);
    }

    public function getTopOnlineGrowthStocks(): array
    {
        return $this->request('GET', '/api/websiteTraffic/screener', [
            'country' => 'us',
        ]);
    }

    public function getTrendingStocks(): array
    {
        return $this->request('GET', '/api/stocks/gettrendingstocks/', [
            'daysago' => '30',
            'which' => 'most',
            'country' => 'us',
            'break' => time(),
        ]);
    }

    public function getTopExperts(string $expertType): array
    {
        $validExpertTypes = ['analyst', 'blogger', 'insider', 'institutional', 'user'];

        if (! in_array($expertType, $validExpertTypes, true)) {
            throw new InvalidArgumentException("Invalid expert type: $expertType. Valid types are: ".implode(', ', $validExpertTypes));
        }

        $params = $expertType === 'analyst' ? [
            'expertType' => 'analyst',
            'numExperts' => '100',
            'period' => 'year',
            'benchmark' => 'none',
        ] : [
            'expertType' => $expertType,
            'numExperts' => '100',
        ];

        return $this->request('GET', '/api/experts/GetTop25Experts/', $params);
    }

    public function getAnalystProjection(string $ticker): array
    {
        return $this->request('GET', '/api/compare/analystRatings/tickers/', [
            'tickers' => strtolower($ticker), // Преобразуем в нижний регистр
        ]);
    }

    public function getNewsSentiment(string $ticker): array
    {
        return $this->request('GET', '/api/stocks/getNews/', [
            'ticker' => $ticker,
        ]);
    }
}
