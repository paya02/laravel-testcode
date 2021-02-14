<?php

namespace Tests\Unit;

use App\Services\CalculatePointService;
use PHPUnit\Framework\TestCase;

class CalculatePointServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     * @dataProvider getProvider_for_calcPoint
     */
    public function calcPoint(int $expected, int $amount)
    {
        $result = CalculatePointService::calcPoint($amount);

        $this->assertSame($expected, $result);
    }

//    /**
//     * @test
//     */
//    public function calcPoint_金額が0ならポイントは0()
//    {
//        $result = CalculatePointService::calcPoint(0);
//
//        // $resultが0であることを確認
//        $this->assertSame(0, $result);
//    }
//
//    /**
//     * @test
//     */
//    public function calcPoint_金額が1000ならポイントは10()
//    {
//        $result = CalculatePointService::calcPoint(1000);
//
//        // $resultが0であることを確認
//        $this->assertSame(10, $result);
//    }

    // ----------------------------
    // データプロバイダ
    // ----------------------------
    public function getProvider_for_calcPoint(): array {
        return [
            '購入金額が0なら0ポイント' => [0, 0],
            '購入金額が999なら0ポイント' => [0, 999],
            '購入金額が1000なら0ポイント' => [10, 1000],
            '購入金額が9999なら99ポイント' => [99, 9999],
            '購入金額が10000なら200ポイント' => [200, 10000],
        ];
    }
}
