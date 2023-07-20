<?php

namespace App\Parser\Services;

use App\Parser\Clients\CbrClient;
use App\Parser\Exceptions\EmptyDataException;
use App\Parser\Infrastructure\Cache;
use App\Parser\Infrastructure\Config;
use App\Parser\Interfaces\CurrencyModelInterface;
use DateTime;
use Exception;

class CurrencyService
{

    /**
     * Parse single date by default using current date
     *
     * @throws EmptyDataException
     * @throws Exception
     */
    public function parseDate( CurrencyModelInterface $storageClass , DateTime|null $date )
    {
        if (empty($date)) {
            $date = new DateTime();
        }

        $data = (new CbrClient())->getRates($date);
        foreach ($data as $one) {
            $storageClass->store($one);
        }

    }

}
