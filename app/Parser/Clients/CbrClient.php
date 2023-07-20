<?php

namespace App\Parser\Clients;

use App\Parser\Dtos\CurrencyDto;
use App\Parser\Exceptions\EmptyDataException;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Http;

class CbrClient
{

    const BASE_URL = 'https://www.cbr.ru/scripts/XML_daily.asp';

    /**
     * @return CurrencyDto[]
     * @throws EmptyDataException
     */
    public function getRates(DateTime $date): array
    {
        try {
            $response = $this->getData($date);
            $data = $this->parseResponse($response);
        } catch (Exception $e) {
            print_r($e);
        }
        if (empty($data)) {
            throw new EmptyDataException();
        }
        $return = [];

        foreach ($data->Valute as $one) {
            $tmp = new CurrencyDto();
            $tmp->date = $date->format('Y-m-d');
            $tmp->currency_id = $one->{"@attributes"}->ID;
            $tmp->num_code = $one->NumCode;
            $tmp->char_code = $one->CharCode;
            $tmp->nominal = (int)$one->Nominal;
            $tmp->value = (float)str_replace(',', '.', $one->Value);
            $tmp->name = $one->Name;
            $return[] = $tmp;
        }

        return $return;
    }

    /**
     * Download data from service provider
     *
     * @param DateTime $date
     * @return string
     */
    private function getData(DateTime $date): string
    {
        $link = $this->getRequestLink($date->format('d/m/Y'));
        return Http::get($link)->body();
    }

    /**
     * Build Link with date variable
     *      *
     * @param string $date
     * @return string
     */
    private function getRequestLink(string $date): string
    {
        return self::BASE_URL . '?date_req=' . $date;
    }

    /**
     * Convert XML to Json
     *
     * @param $response
     * @return bool|object
     */

    private function parseResponse($response): bool|object
    {
        return json_decode(json_encode(simplexml_load_string($response)));

    }


}
