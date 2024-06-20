<?php

namespace Tests\Unit;


use App\Models\User;
use App\Services\ApiService;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ApiServiceTest extends TestCase
{
    public function test_constructor_can_set_properties()
    {
        // $user = new User();
        // $service = new ApiService($user);
        // $this->assertInstanceOf(ApiService::class, $service);

        // $reflection = new ReflectionClass($service);

        // $apiLinkProperty = $reflection->getProperty('apiLink');
        // $apiLinkProperty->setAccessible(true);
        // $this->assertNotNull($apiLinkProperty->getValue($service));

        // $paramsProperty = $reflection->getProperty('params');
        // $paramsProperty->setAccessible(true);
        // $expectedParams = [
        //     'range' => '1d',
        //     'interval' => '1d',
        //     'fundamental' => 'true',
        //     'token' => env('BRAPI_TOKEN'),
        // ];
        // $this->assertEquals($expectedParams, $paramsProperty->getValue($service));
    }
}
