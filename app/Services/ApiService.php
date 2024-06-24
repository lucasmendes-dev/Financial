<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\SavedApiValues;
use App\Models\User;


class ApiService
{
    private $assets;
    private $apiValues;
    
    public function __construct(User $user)
    {
        $this->apiValues = SavedApiValues::where('user_id', $user->id)->get();
        $this->assets = Asset::where('user_id', $user->id)->get();
    }

    public function processData(): array
    {
        if ($this->assets->count() == 0) {
            return null;
        }
        return $this->buildArrayWithAllValues();
    }

    public function saveValuesOnDB(User $user): void
    {
        $brApi = new BrApiService($user);
        $values = $brApi->fetchData();

        foreach ($values as $value) {
            SavedApiValues::updateOrInsert(
                ['symbol' => $value['symbol'], 'user_id' => $user->id],
                [
                    'regular_market_price' => $value['regular_market_price'],
                    'regular_market_change_percent' => $value['regular_market_change_percent'],
                    'regular_market_change' => $value['regular_market_change'],
                    'logo_url' => $value['logo_url'],
                ]
            );
        }
    }


    private function buildArrayWithAllValues(): array
    {
        $processedData = [];

        $currentPrice = $this->getCurrentPrice();
        $dailyVariation = $this->getDailyVariation();
        $dailyMoneyVariation = $this->getDailyMoneyVariation();
        $totalPercentVariation = $this->getTotalPercentVariation();
        $totalMoneyVariation = $this->getTotalMoneyVariation();
        $patrimony = $this->getPatrimony();
        $totalValues = $this->getTotalValues($dailyMoneyVariation, $totalMoneyVariation, $patrimony);
        $logoUrl = $this->getLogoUrl();

        $processedData = array_map(function ($current, $dailyVar, $dailyMoneyVar, $totalPercentVar, $totalMoneyVar, $patrimony, $total, $logo) {
            return [
                'current_price' => $this->formatNumber($current),
                'daily_variation' => $dailyVar,
                'daily_money_variation' => $dailyMoneyVar,
                'total_percent_variation' => $totalPercentVar, false,
                'total_money_variation' => $totalMoneyVar,
                'patrimony' => $patrimony,
                'total_values' => $this->formatNumber($total),
                'logo_url' => $logo
            ];
        }, $currentPrice, $dailyVariation, $dailyMoneyVariation, $totalPercentVariation, $totalMoneyVariation, $patrimony, $totalValues, $logoUrl);

        return $processedData;
    }

    private function getCurrentPrice(): array
    {
        return $this->apiValues->pluck('regular_market_price')->all();
    }

    private function getDailyVariation()
    {
        return $this->apiValues->pluck('regular_market_change_percent')->all();
    }

    private function getDailyMoneyVariation(): array
    {
        $quantity = $this->assets->pluck('quantity');
        $lastMoneyVariation = $this->apiValues->pluck('regular_market_change');

        $dailyMoneyVariation = [];
        foreach ($lastMoneyVariation as $key => $variation) {
            $dailyMoneyVariation[] = $variation * $quantity[$key];
        }

        return $dailyMoneyVariation;
    }

    private function getTotalPercentVariation(): array
    {
        $averagePrice = $this->assets->pluck('average_price')->all();
        $currentPrice = $this->apiValues->pluck('regular_market_price')->all();

        $result = array_map(function ($a, $b) {
            return (($b - $a) / $a) * 100;
        }, $averagePrice, $currentPrice);

        return $result;
    }

    private function getTotalMoneyVariation(): array
    {
        $currentPrice = $this->apiValues->pluck('regular_market_price')->all();
        $assetQuantity = $this->assets->pluck('quantity')->all();
        $initialValue = $this->assets->pluck('average_price')->all();

        $result = array_map(function ($current, $qty, $initial) {
            return ($current - $initial) * $qty;
        }, $currentPrice, $assetQuantity, $initialValue);

        return $result;
    }

    private function getPatrimony(): array
    {
        $currentPrice = $this->apiValues->pluck('regular_market_price')->all();
        $assetQuantity = $this->assets->pluck('quantity')->all();

        $result = array_map(function ($a, $b) {
            return $a * $b;
        }, $currentPrice, $assetQuantity);

        return $result;
    }

    private function getTotalValues(array $dailyMoneyVariation, array $totalMoneyVariation, array $patrimony): array
    {
        $convertToFloat = function ($value) {
            return floatval(str_replace(',', '.', $value));
        };

        $dailyMoneyVariation = array_map($convertToFloat, $dailyMoneyVariation);
        $totalMoneyVariation = array_map($convertToFloat, $totalMoneyVariation);
        $patrimony = array_map($convertToFloat, $patrimony);

        $dailyMoney = array_sum($dailyMoneyVariation);
        $totalMoney = array_sum($totalMoneyVariation);
        $patrim = array_sum($patrimony);

        return [$dailyMoney, $totalMoney,$patrim];
    }

    private function formatNumber($number, bool $withoutComma = true): string
    {
        if (!$withoutComma) {
            return number_format($number, 2);
        }
        return number_format($number, 2, ',', '.');
    }

    public function stocksAndReitSum(array $processed): array
    {
        $stocksSum = $reitSum = $stocksProfit = $reitProfit =  0;
        foreach($this->assets as $key => $asset) {
            if($asset->type == 'stocks') {
                $stocksSum += $processed[$key]['patrimony'];
                $stocksProfit += $processed[$key]['total_money_variation'];
            } else {
                $reitSum += $processed[$key]['patrimony'];
                $reitProfit += $processed[$key]['total_money_variation'];
            }
        }
        return [
            'stocksSum' => $stocksSum,
            'reitSum' => $reitSum,
            'stocksProfit' => $stocksProfit,
            'reitProfit' => $reitProfit
        ];
    }

    public function getLogoUrl(): array
    {
        return $this->apiValues->pluck('logo_url')->all();
    }
}
