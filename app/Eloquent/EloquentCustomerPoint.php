<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $customer_id
 * @property int $point
 */
class EloquentCustomerPoint extends Model
{
    protected $table = 'customer_points';
    // 自動設定されるタイムスタンプは不要
    public $timestamps = false;

    /**
     * @param int $customerId
     * @param int $point
     * @return bool
     */
    public function addPoint(int $customerId, int $point): bool
    {
        // 書籍の記述
//        return $this->newQuery()
//            ->where('customer_id', $customerId)
//            ->update([
//                $this->getConnection()->raw('point = point + ?', $point)
//            ]) === 1;
        // 書き直し
        return $this->newQuery()
            ->where('customer_id', $customerId)
            ->update([
                'point' => DB::raw("point + ${point}")
            ]) === 1;
    }
}
