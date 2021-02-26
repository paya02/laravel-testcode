<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\CustomerPoint;
use App\Models\PointEvent;
use App\Services\AddPointService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddPointServiceTest extends TestCase
{
    use RefreshDatabase;

    const CUSTOMER_ID = 1;

    protected function setUp(): void
    {
        parent::setUp();

        // ①テストに必要なレコードを登録
        Customer::factory()->create([
            'id' => self::CUSTOMER_ID,
        ]);
        CustomerPoint::factory()->create([
            'customer_id' => self::CUSTOMER_ID,
            'point' => 100,
        ]);
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function add()
    {
        // ②テスト対象メソッドの実行
        $event = new PointEvent(
            self::CUSTOMER_ID,
            '加算イベント',
            10,
            Carbon::create(2018, 8, 4, 12, 34, 56),
        );

        /** @var AddPointService $service */
        $service = app()->make(AddPointService::class);
        $service->add($event);

        // ③テスト結果のアサーション
        $this->assertDatabaseHas('customer_point_events', [
            'customer_id' => self::CUSTOMER_ID,
            'event' => $event->getEvent(),
            'point' => $event->getPoint(),
//            'created_at' => $event->getCreatedAt(),
        ]);
        $this->assertDatabaseHas('customer_points', [
            'customer_id' => self::CUSTOMER_ID,
            'point' => 110,
        ]);
    }
}
