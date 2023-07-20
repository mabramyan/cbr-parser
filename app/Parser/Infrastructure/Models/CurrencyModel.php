<?php

namespace App\Parser\Infrastructure\Models;

use App\Models\Currency;
use App\Parser\Dtos\CurrencyDto;
use App\Parser\Interfaces\CurrencyModelInterface;

class CurrencyModel extends Currency implements CurrencyModelInterface
{
    public function store(CurrencyDto $currencyDto):bool
    {
       $cur = Currency::firstOrNew([
           'date' => $currencyDto->date,
           'char_code' => $currencyDto->char_code,
       ]);

        $cur->fill((array)$currencyDto);
        return $cur->save();
    }

}
