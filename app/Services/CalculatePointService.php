<?php

namespace App\Services;

use Symfony\Component\HttpKernel\Exception\PreconditionRequiredHttpException;

class CalculatePointService
{
//    public function __construct(
//        Product $product
//    )
//    {
//        $this->product = $product;
//    }

    /**
     * @param int $amount
     *
     * @return int
     */
    public static function calcPoint(int $amount): int
    {
        if ($amount < 0) {
            throw new PreconditionRequiredHttpException('購入金額が負の数');
        }

        if ($amount < 1000) {
            return 0;
        }

        if ($amount < 10000) {
            $basePoint = 1;
        } else {
            $basePoint = 2;
        }

        return intval($amount / 100) * $basePoint;
    }
}
