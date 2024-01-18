<?php

namespace App\Services;

libxml_use_internal_errors(true);

use App\Models\Asset;
use App\Models\User;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Http;

class GenerateApiService
{
    private $apiLink;
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->apiLink = env('API_MAIN_LINK');
    }

    public function fetchData(): array
    {
        $assets = Asset::where('user_id', $this->user->id)->get();
        $assetValues = [];

        foreach ($assets as $asset) {
            $response = $this->fetchApiData($asset);

            if ($response->successful()) {
                $assetValues = array_merge($assetValues, $this->processApiResponse($asset, $response));
            }
        }

        return $assetValues;
    }

    private function fetchApiData($asset)
    {
        return Http::get("$this->apiLink/{$asset->code}.SA");
    }

    public function fetchOneAssetData($assetCode)
    {
        return Http::get("$this->apiLink/{$assetCode}.SA");
    }

    public function processApiResponse($asset, $response): array
    {
        $assetValues = [];
        $document = new DOMDocument();
        $document->loadHTML($response);
        $xPath = new DOMXPath($document);

        $prices = $xPath->query(env('PRICE_XPATH'));
        $percentVariation = $xPath->query(env('PERCENT_XPATH'));
        $moneyVariation = $xPath->query(env('MONEY_XPATH'));

        foreach ($prices as $index => $price) {
            $assetValues[] = [
                'code' => $asset->code,
                'last_saved_price' => $price->textContent,
                'last_percent_variation' => preg_match('/\((.*?)%\)/', $percentVariation[$index]->textContent, $matches) ? $matches[1] : '',
                'last_money_variation' => $moneyVariation[$index]->textContent,
            ];
        }

        return $assetValues;
    }
}
