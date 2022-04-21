<?php

namespace App\Services\Communication\Twilio;

class CategoryResponse
{
    public static function toArray(array $categoryResponseData, float $categoryFee = 1)
    {
        return [
            'count' => (int)data_get($categoryResponseData, 'count'),
            'usage' => (int)data_get($categoryResponseData, 'usage'),
            'usage_unit' => data_get($categoryResponseData, 'usage_unit'),
            'price' => (float)data_get($categoryResponseData, 'price'),
            'tratta_price' => round(data_get($categoryResponseData, 'usage') * $categoryFee , 2),
        ];
    }
}
