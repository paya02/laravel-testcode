<?php

namespace App\Models;

use App\Services\CalculatePointService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * 金額からポイントを計算して返す
     *
     * @return integer
     */
    public function getPointAttribute()
    {
        return CalculatePointService::calcPoint($this->price);
    }
}
