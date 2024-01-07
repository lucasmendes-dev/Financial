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
        $endpoint = ($asset->type === 'reit') ? 'fiis' : 'acoes';
        return Http::get("$this->apiLink/$endpoint/{$asset->code}");
    }

    private function processApiResponse($asset, $response): array
    {
        $assetValues = [];
        $document = new DOMDocument();
        $document->loadHTML($response);
        $xPath = new DOMXPath($document);
        $values = $xPath->query(env('PRICE_XPATH'));

        foreach ($values as $value) {
            $formattedString = preg_replace('/[^0-9,]/', '', $value->textContent);
            $parseToFloat = floatval(str_replace(',', '.', $formattedString));

            $assetValues[] = [
                'code' => $asset->code,
                'price' => $parseToFloat,
            ];
        }

        return $assetValues;
    }
}
