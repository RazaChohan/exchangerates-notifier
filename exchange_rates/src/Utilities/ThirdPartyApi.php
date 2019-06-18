<?php

namespace App\Utilities;

use App\Entity\ExchangeRate;
use DateTime;

class ThirdPartyApi
{
    /**
     * @var CurlHelper
     */
    private $curlHelper;

    /***
     * ThirdPartyApi constructor.
     */
    public function __construct()
    {
        $this->curlHelper = new CurlHelper();
    }

    /**
     * Get all exchange rates for a particular base
     *
     * @param $baseCurrency
     * @return array list of exchange rates
     */
    public function getExchangeRates($baseCurrency) {
        $exchangeRates = [];
        $apiResponse = $this->curlHelper->getCall('https://api.exchangeratesapi.io/2010-01-12', true);
        $ratesResponse = isset($apiResponse->rates) ? $apiResponse->rates : [];
        foreach($ratesResponse as $targetCurrency => $value) {
            $exchangeRate = new ExchangeRate();
            $date = !empty($apiResponse->date) ? $apiResponse->date : date('Y-m-d');
            $exchangeRate->setDate(DateTime::createFromFormat('Y-m-d', $date) );
            $exchangeRate->setTarget($targetCurrency);
            $exchangeRate->setBase($baseCurrency);
            $exchangeRate->setAmount($value);
            $exchangeRates[] = $exchangeRate;
        }
        return $exchangeRates;
    }
}