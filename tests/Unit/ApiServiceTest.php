<?php

namespace Tests\Unit;

use App\Services\ApiService;
use App\Models\Asset;
use Mockery;
use Mockery\MockInterface;
use ReflectionClass;
use App\Models\SavedApiValues;
use Tests\TestCase;
use App\Models\User;

class ApiServiceTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function test_constructor_can_set_properties()
    {
        $user = new User();
        $service = new ApiService($user);
        $this->assertInstanceOf(ApiService::class, $service);

        $assets = Asset::where('user_id', $user->id)->get();
        $apiValues = SavedApiValues::where('user_id', $user->id)->get();

        $reflection = new ReflectionClass($service);

        $apiValuesProperty = $reflection->getProperty('apiValues');
        $apiValuesProperty->setAccessible(true);
        $this->assertEquals($apiValues, $apiValuesProperty->getValue($service));

        $assetsProperty = $reflection->getProperty('assets');
        $assetsProperty->setAccessible(true);
        $this->assertEquals($assets, $assetsProperty->getValue($service));
    }

    public function test_can_process_data()
    {
        $user = new User();
        $service = new ApiService($user);

        $data = $service->processData();
        $this->assertIsArray($data);
        $this->assertEmpty($data);
        //criar um pra ver com dados preenchidos
    }

    public function test_can_get_current_prices()
    {
        $user = new User();
        $service = new ApiService($user);

        $reflection = new ReflectionClass($service);

        $method = $reflection->getMethod('getCurrentPrice');
        $method->setAccessible(true);
        
        $currentPrices = $method->invoke($service);
        $this->assertEquals([], $currentPrices);

    }
}
