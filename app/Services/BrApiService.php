<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\User;

class BrApiService
{
    private $apiLink;
    private $user;
    private $params;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->apiLink = env('BRAPI_LINK');
        $this->params = [
            'range' => '1d',
            'interval' => '1d',
            'fundamental' => 'true',
            'token' => env('BRAPI_TOKEN'),
        ];
    }

    public function fetchData(): array
    {
        $assets = Asset::where('user_id', $this->user->id)->get();
        $assetValues = [];
        
        foreach ($assets as $asset) {
            $response = $this->fetchApiData($asset->code);

            if ($response) {
                $assetValues = array_merge($assetValues, $this->processApiResponse($response));
            }
        }
        return $assetValues;
    }

    public function fetchApiData($assetCode): array
    {
        $query = http_build_query($this->params);
        $fullUrl = $this->apiLink . "$assetCode" . "?" . $query;

        $response = file_get_contents($fullUrl);
        
        if ($response !== false) {
            $data = json_decode($response, true);
            return $data;
        }
        return [];
    }

    public function processApiResponse(array $response): array
    {
        $assetValues = [];
        if ($this->hasRequiredKeys($response['results'][0])) {
            $assetValues[] = [
                'symbol' => $response['results'][0]['symbol'],
                'regular_market_price' => $response['results'][0]['regularMarketPrice'],
                'regular_market_change_percent' => $response['results'][0]['regularMarketChangePercent'],
                'regular_market_change' => $response['results'][0]['regularMarketChange'],
                'logo_url' => $response['results'][0]['logourl']
            ];
        }

        return $assetValues;
    }

    private function hasRequiredKeys(array $array): bool
    {
        $requiredKeys = [
            'symbol',
            'regularMarketPrice',
            'regularMarketChangePercent',
            'regularMarketChange',
            'logourl'
        ];

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $array)) {
                return false;
            }
        }
        return true;
    }
}
