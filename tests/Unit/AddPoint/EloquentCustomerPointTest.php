<?php

namespace Tests\Unit\AddPoint;

use App\Models\Customer;
use App\Models\CustomerPoint;
use App\Eloquent\EloquentCustomerPoint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EloquentCustomerPointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function addPoint()
    {
        // ①テストに必要なレコードを登録
        $customerId = 1;
        Customer::factory()->create([
            'id' => $customerId,
        ]);
        CustomerPoint::factory()->create([
            'customer_id' => $customerId,
            'point' => 100,
        ]);

        // ②テスト対策メソッドの実行
        $eloquent = new EloquentCustomerPoint();
        $result = $eloquent->addPoint($customerId, 10);

        // ③テスト結果のアサーション
        $this->assertTrue($result);
        $this->assertDatabaseHas('customer_points', [
            'customer_id' => $customerId,
            'point' => 110,
        ]);
    }
}
