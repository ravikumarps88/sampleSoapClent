<?php
/**
 * Handles the soap call for given country name or city name
 *
 * @package AppBundle\Services
 * @author Ravikumar P S <ravikumarps88@yahoo.co.in>
 */
namespace AppBundle\Services;

use BeSimple\SoapClient\SoapClient;

class SoapClientApi
{
    const SOAPAPIPARAM = 'GetWeather';

    /**
     * @param string $url wsdl
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Handles soap call and return weather array
     * @param  string  $country
     * @param  string  $city
     * @return array
     */
    public function soapClientCall($country,$city)
    {
        $url = $this->url;
        $client = new SoapClient($url);

        if (!$city) {

            $city = '';
        }
        if (!$country) {

            $country = '';
        }

        $serviceParams = array (
            self::SOAPAPIPARAM => array (
                "CityName" => $city,
                "CountryName" => $country
            )
        );
        $result = $client->__soapCall(self::SOAPAPIPARAM, $serviceParams);
        $weatherResult = $result->GetWeatherResult;

        //converting xml to json and then to array
        if ($weatherResult != 'Data Not Found') {

            $responseXml = simplexml_load_string(preg_replace('/(<\?xml[^?]+?)utf-16/i', '$1utf-8', $weatherResult));
            $responseJson = json_encode($responseXml);
            $responseArray = json_decode($responseJson,TRUE);
        } else {

            $responseArray = 'Data not found';
        }

        return $responseArray;
    }
}
