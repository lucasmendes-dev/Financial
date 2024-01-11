<?php

namespace App\Services;

use App\Models\ApiValues;
use App\Models\Asset;
use App\Models\User;


class ApiService
{
    private $assets;
    private $apiValues;
    
    public function __construct(User $user)
    {
        $this->apiValues = ApiValues::where('user_id', $user->id)->get();
        $this->assets = Asset::where('user_id', $user->id)->get();
    }

    public function processedData()
    {
        if ($this->assets->count() == 0) {
            return null;
        }
        return $this->buildArrayWithAllValues();
    }

    public function saveValuesOnDB(User $user)
    {
        $generator = new GenerateApiService($user);
        $values = $generator->fetchData();

        foreach ($values as $value) {
            ApiValues::updateOrInsert(
                ['code' => $value['asset_code'], 'user_id' => $user->id],
                [
                    'last_saved_price' => $value['current_price'],
                    'last_percent_variation' => $value['daily_percent_variation'],
                    'last_money_variation' => $value['daily_money_variation'],
                    'user_id' => $user->id
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

        $processedData = array_map(function ($current, $dailyVar, $dailyMoneyVar, $totalPercentVar, $totalMoneyVar, $patrimony, $total) {
            return [
                'current_price' => $current,
                'daily_variation' => $dailyVar,
                'daily_money_variation' => $dailyMoneyVar,
                'total_percent_variation' => $this->formatNumber($totalPercentVar),
                'total_money_variation' => $this->formatNumber($totalMoneyVar),
                'patrimony' => $patrimony,
                'total_values' => $this->formatNumber($total),
            ];
        }, $currentPrice, $dailyVariation, $dailyMoneyVariation, $totalPercentVariation, $totalMoneyVariation, $patrimony, $totalValues);

        return $processedData;
    }

    private function getCurrentPrice(): array
    {
        return $this->apiValues->pluck('last_saved_price')->all();
    }

    private function getDailyVariation()
    {
        return $this->apiValues->pluck('last_percent_variation')->all();
    }

    private function getDailyMoneyVariation()
    {
        $quantity = $this->assets->pluck('quantity');
        $lastMoneyVariation = $this->apiValues->pluck('last_money_variation');

        $dailyMoneyVariation = [];
        foreach ($lastMoneyVariation as $key => $variation) {
            $dailyMoneyVariation[] = $variation * $quantity[$key];
        }

        return $dailyMoneyVariation;
    }

    private function getTotalPercentVariation()
    {
        $averagePrice = $this->assets->pluck('average_price')->all();
        $currentPrice = $this->apiValues->pluck('last_saved_price')->all();

        $result = array_map(function ($a, $b) {
            return (($b - $a) / $a) * 100;
        }, $averagePrice, $currentPrice);

        return $result;
    }

    private function getTotalMoneyVariation()
    {
        $currentPrice = $this->apiValues->pluck('last_saved_price')->all();
        $assetQuantity = $this->assets->pluck('quantity')->all();
        $initialValue = $this->assets->pluck('average_price')->all();

        $result = array_map(function ($current, $qty, $initial) {
            return ($current - $initial) * $qty;
        }, $currentPrice, $assetQuantity, $initialValue);

        return $result;
    }

    private function getPatrimony()
    {
        $currentPrice = $this->apiValues->pluck('last_saved_price')->all();
        $assetQuantity = $this->assets->pluck('quantity')->all();

        $result = array_map(function ($a, $b) {
            return $a * $b;
        }, $currentPrice, $assetQuantity);

        return $result;
    }

    private function getTotalValues($dailyMoneyVariation, $totalMoneyVariation, $patrimony): array
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

    private function formatNumber($number): string
    {
        return number_format($number, 2, ',', '.');
    }
}
