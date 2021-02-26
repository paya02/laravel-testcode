<?php

namespace App\Services;

use App\Eloquent\EloquentCustomerPoint;
use App\Eloquent\EloquentCustomerPointEvent;
use App\Models\PointEvent;
use Illuminate\Database\Connectors\ConnectorInterface;

class AddPointService
{
    /** @var EloquentCustomerPointEvent */
    private $eloquentCustomerPointEvent;

    /** @var EloquentCustomerPoint */
    private $eloquentCustomerPoint;

    /** @var ConnectorInterface */
    private $db;

    /**
     * @param EloquentCustomerPointEvent $eloquentCustomerPointEvent
     * @param EloquentCustomerPoint $eloquentCustomerPoint
     */
    public function __construct(
        EloquentCustomerPointEvent $eloquentCustomerPointEvent,
        EloquentCustomerPoint $eloquentCustomerPoint
    ) {
        $this->eloquentCustomerPointEvent =$eloquentCustomerPointEvent;
        $this->eloquentCustomerPoint = $eloquentCustomerPoint;
        $this->db = $eloquentCustomerPointEvent->getConnection();
    }

    /**
     * @param PointEvent $event
     * @param \Throwable
     */
    public function add(PointEvent $event)
    {
        $this->db->transaction(function () use ($event) {
            // ポイントイベント保存
            $this->eloquentCustomerPointEvent->register($event);

            // 保有ポイント更新
            $this->eloquentCustomerPoint->addPoint(
                $event->getCustomerId(),
                $event->getPoint()
            );
        });
    }
}
