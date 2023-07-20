<?php

namespace App\Parser\Interfaces;
use App\Parser\Dtos\CurrencyDto;

Interface CurrencyModelInterface
{
    public function store(CurrencyDto $currencyDto):bool;

}
