<?php

namespace App\Services;

use App\Models\ApiValues;
use App\Models\User;


class ApiService
{
    private $allData;
    private $assets;
    private $apiValues;
    
    public function __construct()
    {
        $this->apiValues = ApiValues::all();
    }

    public function processedData()
    {
        //return $this->buildArrayWithAllValues();
    }

    public function saveValuesOnDB(User $user)
    {
        $generator = new GenerateApiService($user);
        $values = $generator->fetchData();

        foreach ($values as $value) {
            ApiValues::updateOrInsert(
                ['code' => $value['code']],
                ['last_saved_price' => $value['price']]
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
        
    }

    private function getDailyMoneyVariation()
    {
        
    }

    private function getTotalPercentVariation()
    {
        
    }
    
    private function getTotalMoneyVariation()
    {
        
    }

    private function getPatrimony()
    {
        
    }

    private function getTotalValues($totalMoneyVariation, $patrimony)
    {
        
    }
}
