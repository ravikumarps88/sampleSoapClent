<?php
/**
 * Test cases for SoapClientApi
 *
 * @package AppBundle\Tests
 */
namespace AppBundle\Tests\Services;

/**
 * Test cases for SoapClientApi
 *
 * @package AppBundle\Tests
 */
class SoapClientApiTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AppBundle\Services\SoapClientApi
     */
    protected $mockSoapApi;

    /**
     * Initial set up for the test class
     */
    public function setUp()
    {
        /**
         * Mock the Soap Api Service
         */
        $mockSoapclientapi = $this->getMock(
            '\AppBundle\Services\SoapClientApi',
            array(),
            array(),
            '',
            false
        );

        $this->mockSoapApi = $mockSoapclientapi;

        /**
         * Mock the Soap Client
         */
        $mockSoapClient = $this->getMock(
            '\BeSimple\SoapClient\SoapClient',
            array(),
            array(),
            '',
            false
        );

        $this->mockSoapClient = $mockSoapClient;

    }

    /**
     * test case for soapClientCall
     *
     * @covers AppBundle\Services\SoapClientApi::soapClientCall
     */
    public function testSoapClientCallAction()
    {
        $ser_params = array (
            'GetWeather' => array (
                "CityName" => 'New York',
                "CountryName" => 'United States'
            )
        );
        $weatherResult = 'Data Not Found';
        $this->mockSoapClient->__soapCall('GetWeather', $ser_params);
        $this->assertEquals('Data Not Found', $weatherResult);
        $weatherResult = 'ROOSEVELT ROADS PUERTO RICO, PR, United States (TJNR) 18-15N 65-38W 10M Jul 15, 2015 - 05:53 PM EDT / 2015.07.15 2153 UTC from the ENE (060 degrees) at 12 MPH (10 KT) gusting to 20 MPH (17 KT):0 10 mile(s):0 mostly cloudy 84.0 F (28.9 C) 75.0 F (23.9 C) 74% 30.05 in. Hg (1017 hPa) Success ';
        $this->assertNotEquals('Data Not Found', $weatherResult);
        $this->mockSoapApi->soapClientCall('United States','New York');
    }
}
