<?php

namespace App\Utilities;

use App\Entity\ExchangeRate;
use DateTime;

class ThirdPartyApi
{
    private $apiUrl;
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
        $this->apiUrl = $_ENV['THIRD_PARTY_API_URL'];
    }

    /**
     * Get all exchange rates for a particular base
     *
     * @param $baseCurrency
     * @param $date
     * @return array list of exchange rates
     */
    public function getExchangeRates($baseCurrency, $date) {
        $exchangeRates = [];
        if(!empty($date)) {
            $this->apiUrl = $this->apiUrl . "/$date";
        }
        $apiResponse = $this->curlHelper->getCall($this->apiUrl . '?base=' . $baseCurrency, true);
        $ratesResponse = isset($apiResponse->rates) ? $apiResponse->rates : [];
        foreach($ratesResponse as $targetCurrency => $value) {
            $exchangeRate = new ExchangeRate();
            $date = !empty($apiResponse->date) ? $apiResponse->date : date('Y-m-d');
            $date = DateTime::createFromFormat('Y-m-d', $date);
            $exchangeRate->setDate($date);
            $exchangeRate->setTarget($targetCurrency);
            $exchangeRate->setBase($baseCurrency);
            $exchangeRate->setAmount($value);
            $exchangeRates[] = $exchangeRate;
        }
        return $exchangeRates;
    }
}