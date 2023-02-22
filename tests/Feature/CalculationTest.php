<?php

namespace Tests\Feature;

use App\Traits\ProductTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalculationTest extends TestCase
{
    use ProductTrait;
    protected $testData;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_example()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    /** @test */
    public function thirtyPercentDiscountTest()
    {
        $testData =  [
            'sku' => '000002',
            'name' => 'john',
            'category' => 'boots',
            'price' => '7100'
        ];
        $response = $this->discountCalculator($testData['sku'], $testData['category'], $testData['price']);
        $this->assertEquals(4970, $response['newPrice']);
    }

    /** @test */
    public function fifteenPercentDiscountTest()
    {
        $testData = [
            'sku' => '000003',
            'name' => 'Robert',
            'category' => 'sandals',
            'price' => '7100'
        ];
        $response = $this->discountCalculator($testData['sku'], $testData['category'], $testData['price']);
        $this->assertEquals(6035, $response['newPrice']);
    }

    /** @test */
    public function noDiscountTest()
    {
        $testData =  [
            'sku' => '000002',
            'name' => 'Mary',
            'category' => 'sandals',
            'price' => '7100'
        ];
        $response = $this->discountCalculator($testData['sku'], $testData['category'], $testData['price']);
        $this->assertEquals(7100, $response['newPrice']);
    }
}
