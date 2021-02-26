<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\CustomerPoint;
use App\Eloquent\EloquentCustomerPoint;
use App\Eloquent\EloquentCustomerPointEvent;
use App\Models\PointEvent;
use App\Services\AddPointService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Unit\AddPoint\EloquentCustomerPointEventTest;

class AddPointServiceWithMockTest extends TestCase
{
    private $customerPointEventMock;
    private $customerPointMock;

    protected function setUp(): void
    {
        parent::setUp();

        // ①Eloquentクラスのモック化
        $this->customerPointEventMock = new class extends EloquentCustomerPointEvent
        {
            /** @var PointEvent */
            public $pointEvent;

            public function register(PointEvent $event)
            {
                $this->pointEvent = $event;
            }
        };

        $this->customerPointMock = new class extends EloquentCustomerPoint
        {
            /** @var int */
            public $customerId;

            /** @var int */
            public $point;

            public function addPoint(int $customerId, int $point): bool
            {
                $this->customerId = $customerId;
                $this->point = $point;

                return true;
            }
        };
    }

    /**
     * @test
     */
    public function add()
    {
        // ②テスト対策メソッドの実行
        $customerId = 1;
        $event = new PointEvent(
            $customerId,
            '加算イベント',
            10,
            Carbon::create(2018, 8, 4, 12, 34, 56),
        );
        $service = new AddPointService(
            $this->customerPointEventMock,
            $this->customerPointMock
        );
        $service->add($event);

        // ③テスト結果のアサーション
        $this->assertEquals($event, $this->customerPointEventMock->pointEvent);
        $this->assertSame($customerId, $this->customerPointMock->customerId);
        $this->assertSame(10, $this->customerPointMock->point);
    }
}
