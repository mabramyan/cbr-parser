<?php

namespace App\Services;

use App\Jobs\LoadCurrencyJob;
use App\Models\Currency;
use App\Services\Constenats\CurrencyCodes;
use App\Services\Dtos\CurrencyRateDto;
use App\Services\Exceptions\WrongCurrencyCodeException;
use Closure;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class RateService
{

    /**
     * @throws WrongCurrencyCodeException
     */
    public function getRate($currencyCode, $baseCurrencyCode = 'RUR'): CurrencyRateDto
    {


        if ($currencyCode === $baseCurrencyCode) {
            throw new WrongCurrencyCodeException('Currency code should not be the same');
        }

        //initial default values for currency and baseCurrency

        $currency = new Currency([
            'value' => 1,
            'nominal' => 1,
        ]);
        $currencyOld = new Currency([
            'value' => 1,
            'nominal' => 1,
        ]);
        $baseCurrency = new Currency([
            'value' => 1,
            'nominal' => 1,
        ]);
        $baseCurrencyOld = new Currency([
            'value' => 1,
            'nominal' => 1,
        ]);


        if ($currencyCode !== CurrencyCodes::RUR) {
            $date = new DateTime();
            $currency = Cache::remember($currencyCode, Config::get('cache.cache_time'), RateService::updateRatesAndGetCurrency($currencyCode, $date));
            $date->sub(new DateInterval('P1D'));
            $currencyOld = Cache::remember($currencyCode.'_old', Config::get('cache.cache_time'), RateService::updateRatesAndGetCurrency($currencyCode, $date));
        }
        if ($baseCurrencyCode !== CurrencyCodes::RUR) {
            $date = new DateTime();

            $baseCurrency = Cache::remember($baseCurrencyCode, Config::get('cache.cache_time'), RateService::updateRatesAndGetCurrency($baseCurrencyCode, $date));
            $date->sub(new DateInterval('P1D'));
            $baseCurrencyOld = Cache::remember($baseCurrencyCode.'_old', Config::get('cache.cache_time'), RateService::updateRatesAndGetCurrency($baseCurrencyCode, $date));

        }


        //calculate cross rate
        $nominal = $currency->nominal;
        $rate = ($baseCurrency->nominal / $baseCurrency->value) * $currency->value;
        $oldRate = ($baseCurrencyOld->nominal / $baseCurrencyOld->value) * $currencyOld->value;

        $return = new CurrencyRateDto();
        $return->currency = $currencyCode;
        $return->baseCurrency = $baseCurrencyCode;
        $return->nominal = $nominal;
        $return->rate = round($rate, 4);
        $return->difference = round($rate - $oldRate, 6);
        return $return;
    }

    public static function updateRatesAndGetCurrency(string $currency, DateTime $date): Closure
    {
        return function () use ($currency, $date) {
            LoadCurrencyJob::dispatchSync($date);
            return RateService::getCurrencyFromDb($currency, $date);
        };
    }

    public static function getCurrency(string $currency, DateTime $date): Closure
    {
        return function () use ($currency, $date) {
            return RateService::getCurrencyFromDb($currency, $date);
        };
    }


    public static function getCurrencyFromDb(string $currency, DateTime $date)
    {
       return Currency::where('date', $date->format('Y-m-d'))
            ->where('char_code', $currency)
            ->first();
    }


}
