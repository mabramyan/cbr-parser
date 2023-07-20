<?php

namespace App\Services\Dtos;

class CurrencyRateDto
{
    public string $currency;
    public string $baseCurrency;
    public int $nominal;
    public float $rate;
    public float $difference;
}
