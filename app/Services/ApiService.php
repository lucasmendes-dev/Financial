<?php

namespace App\Services;

use App\Models\ApiValues;
use App\Models\Asset;
use App\Models\User;


class ApiService
{
    private $allData;
    private $assets;
    private $apiValues;
    
    public function __construct(User $user)
    {
        $this->apiValues = ApiValues::all();
        $this->assets = Asset::where('user_id', $user->id)->get();
    }

    public function processedData()
    {
        return $this->buildArrayWithAllValues();
    }

    public function saveValuesOnDB(User $user)
    {
        $generator = new GenerateApiService($user);
        $values = $generator->fetchData();

        foreach ($values as $value) {
            ApiValues::updateOrInsert(
                ['code' => $value['asset_code']],
                [
                    'last_saved_price' => $value['current_price'],
                    'last_percent_variation' => $value['daily_percent_variation'],
                    'last_money_variation' => $value['daily_money_variation'],
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
        $totalValues = $this->getTotalValues($totalMoneyVariation, $patrimony);

        $processedData = array_map(function ($current, $dailyVar, $dailyMoneyVar, $totalPercentVar, $totalMoneyVar, $patrimony, $total) {
            return [
                'current_price' => $current,
                'daily_variation' => $dailyVar,
                'daily_money_variation' => $dailyMoneyVar,
                'total_percent_variation' => $totalPercentVar,
                'total_money_variation' => $totalMoneyVar,
                'patrimony' => $patrimony,
                'total_values' => $total,
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
            $dailyMoneyVariation[] = $this->formatNumber($variation * $quantity[$key]);
        }

        return $dailyMoneyVariation;
    }

    private function getTotalPercentVariation()
    {
        $averagePrice = $this->assets->pluck('average_price')->all();
        $currentPrice = $this->apiValues->pluck('last_saved_price')->all();

        $result = array_map(function ($a, $b) {
            return $this->formatNumber((($b - $a) / $a) * 100);
        }, $averagePrice, $currentPrice);

        return $result;
    }

    private function getTotalMoneyVariation()
    {
        $currentPrice = $this->apiValues->pluck('last_saved_price')->all();
        $assetQuantity = $this->assets->pluck('quantity')->all();
        $initialValue = $this->assets->pluck('average_price')->all();

        $result = array_map(function ($current, $qty, $initial) {
            return $this->formatNumber(($current - $initial) * $qty);
        }, $currentPrice, $assetQuantity, $initialValue);

        return $result;
    }

    private function getPatrimony()
    {
        $currentPrice = $this->apiValues->pluck('last_saved_price')->all();
        $assetQuantity = $this->assets->pluck('quantity')->all();

        $result = array_map(function ($a, $b) {
            return $this->formatNumber($a * $b);
        }, $currentPrice, $assetQuantity);

        return $result;
    }

    private function getTotalValues($totalMoneyVariation, $patrimony): array
    {
        $totalMoney = $this->formatNumber(array_sum($totalMoneyVariation));
        $patrim = $this->formatNumber(array_sum($patrimony));

        return [$totalMoney, $patrim];
    }

    private function formatNumber($number): string
    {
        return number_format($number, 2, ',', '.');
    }
}
