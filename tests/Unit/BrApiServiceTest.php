<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\BrApiService;
use App\Models\User;
use ReflectionClass;

class BrApiServiceTest extends TestCase
{
    public function test_constructor_can_set_properties()
    {
        $user = new User();
        $service = new BrApiService($user);
        $this->assertInstanceOf(BrApiService::class, $service);

        $reflection = new ReflectionClass($service);

        $apiLinkProperty = $reflection->getProperty('apiLink');
        $apiLinkProperty->setAccessible(true);
        $this->assertEquals(env('BRAPI_LINK'), $apiLinkProperty->getValue($service));

        $paramsProperty = $reflection->getProperty('params');
        $paramsProperty->setAccessible(true);
        $expectedParams = [
            'range' => '1d',
            'interval' => '1d',
            'fundamental' => 'true',
            'token' => env('BRAPI_TOKEN'),
        ];
        $this->assertEquals($expectedParams, $paramsProperty->getValue($service));
    }

    // public function test_api_data_can_be_fetched()
    // {
    //     $user = new User();
    //     $service = new BrApiService($user);

    // }
}
