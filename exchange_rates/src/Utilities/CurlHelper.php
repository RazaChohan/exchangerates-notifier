<?php

namespace App\Utilities;
use Symfony\Component\Config\Definition\Exception\Exception;

/***
 * Curl helper providing function for different types of curl calls
 *
 * Class curl_helper
 */
class CurlHelper
{
    /***
     * Get call
     *
     * @param $url
     * @param bool $decodeJson
     *
     * @return array|string
     */
    public function getCall($url, $decodeJson = true)
    {
        $output = null;
        try {
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));

            $output = curl_exec($ch);
            curl_close($ch);

        } catch(Exception $ex) {
            $output = false;
        }
        return $decodeJson ? json_decode($output) : $output;
    }
    /***
     * Get Http code from response of curl request
     *
     * @param $curlObj
     * @return mixed
     */
    private function _getHttpCode($curlObj)
    {
        return curl_getinfo($curlObj, CURLINFO_HTTP_CODE);
    }
}