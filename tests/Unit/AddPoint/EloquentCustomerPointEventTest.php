<?php

namespace Tests\Unit\AddPoint;

use App\Eloquent\EloquentCustomerPointEvent;
use App\Models\Customer;
use App\Models\PointEvent;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EloquentCustomerPointEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function register()
    {
        // ①テストに必要なレコードを登録
        $customerId = 1;
        Customer::factory()->create([
            'id' => $customerId,
        ]);

        // ②テスト対象のメソッドの実行
        $event = new PointEvent(
            $customerId,
            '加算イベント',
            100,
            Carbon::create(2018, 8, 4, 12, 34, 56),
        );
        $sut = new EloquentCustomerPointEvent();
        $sut->register($event);

        // ③テスト結果のアサーション
        $this->assertDatabaseHas('customer_point_events', [
            'customer_id' => $customerId,
            'event' => $event->getEvent(),
            'point' => $event->getPoint(),
//            'created_at' => $event->getCreatedAt(),
        ]);
    }
}
