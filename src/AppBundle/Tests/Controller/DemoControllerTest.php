<?php
/**
 * Handle soap api call
 * @package AppBundle\Tests\Controller
 */
namespace AppBundle\Tests\Controller;
/**
 * Class DemoController
 *
 * @package AppBundle\Controller
 */
class DemoControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Holding the controller mock object
     *
     * @var AppBundle\Controller\DemoController
     */
    protected $mockController;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $mockRepository;

    /**
     * @var Symfony\Component\Form\Form
     */
    protected $mockForm;

    /**
     * @var Symfony\Component\HttpFoundation\Request
     */
    protected $mockRequest;

    /**
     * @var Symfony\Component\Form\FormBuilder
     */
    protected $mockFormBuilder;

    /**
     * Initial setup for test
     */
    public function setup()
    {
        /**
         * Mock default controller
         */
        $mockController = $this->getMock(
            'AppBundle\Controller\DemoController',
            array('getDoctrine',
                'render',
                'createForm',
                'generateUrl',
                'createFormBuilder',
                'addFlash',
                'redirect',
                'get'),
            array(),
            '',
            false
        );
        $this->mockController = $mockController;

        /**
         * Mock the Form
         */
        $mockForm = $this->getMock(
            'Symfony\Component\Form\Form',
            array('handleRequest', 'isValid', 'createView', 'getData','add','bind'),
            array(),
            '',
            false
        );
        $this->mockForm = $mockForm;

        /**
         * Mock the Request
         */
        $mockRequest = $this->getMock(
            'Symfony\Component\HttpFoundation\Request',
            array('isMethod'),
            array(),
            '',
            false
        );
        $this->mockRequest = $mockRequest;

        /**
         * Mock the Form builder
         */
        $mockFormBuilder = $this->getMock(
            'Symfony\Component\Form\FormBuilder',
            array('add','getForm'),
            array(),
            '',
            false
        );
        $this->mockFormBuilder = $mockFormBuilder;

        /**
         * Mock the Service
         */
        $mockService = $this->getMock(
            'AppBundle\Services\SoapClientApi',
            array('soapClientCall'),
            array('http://www.webservicex.net/globalweather.asmx?WSDL'),
            '',
            false
        );
        $this->mockService = $mockService;

        /**
         * Create object for view
         */
        $this->mockView         = new \Symfony\Component\Form\FormView();

    }

    /**
     * test case for api call if post values are there
     *
     * @covers AppBundle\Controller\DemoController::indexAction
     */
    public function testindexAction()
    {

        $defaultData = array('message' => 'Enter City Name Or Country Name For Weather');

        $dataArray = array('countryname' => 'United States','cityname'=>'New york');

        $weatherarray = Array ( 'Location' => 'ROOSEVELT ROADS PUERTO RICO, PR, United States (TJNR) 18-15N 65-38W 10M','Time' => 'Jul 15, 2015 - 05:53 PM EDT / 2015.07.15 2153 UTC', 'Wind' => 'from the ENE (060 degrees) at 12 MPH (10 KT) gusting to 20 MPH (17 KT):0',
            'Visibility' => '10 mile(s):0', 'SkyConditions' => 'mostly cloudy', 'Temperature' => '84.0 F (28.9 C)', 'DewPoint' => '75.0 F (23.9 C)',
           'RelativeHumidity' => '74%', 'Pressure' => '30.05 in. Hg (1017 hPa)', 'Status' => 'Success' );

        $this->mockController->expects($this->once())
                ->method('createFormBuilder')
                ->with($this->equalTo($defaultData))
                ->will($this->returnValue($this->mockFormBuilder));

        $this->mockFormBuilder->expects($this->at(0))
                ->method('add')
                ->with($this->equalTo('countryname'), $this->equalTo('text'))
                ->will($this->returnValue($this->mockFormBuilder));

        $this->mockFormBuilder->expects($this->at(1))
                ->method('add')
                ->with($this->equalTo('cityname'), $this->equalTo('text'))
                ->will($this->returnValue($this->mockFormBuilder));

        $this->mockFormBuilder->expects($this->at(2))
                ->method('add')
                ->with($this->equalTo('search'), $this->equalTo('submit'))
                ->will($this->returnValue($this->mockFormBuilder));

        $this->mockFormBuilder->expects($this->once())
                ->method('getForm')
                ->will($this->returnValue($this->mockForm));

        $this->mockRequest->expects($this->once())
            ->method('isMethod')
            ->with($this->equalTo('POST'))
            ->will($this->returnValue(true));

        $this->mockForm->expects($this->once())
                ->method('bind')
                ->with($this->mockRequest);

        $this->mockForm->expects($this->once())
                ->method('getData')
                ->will($this->returnValue($dataArray));

        $this->mockController->expects($this->once())
                ->method('get')
                ->with($this->equalTo('api.weather.handler'))
                ->will($this->returnValue($this->mockService));

        $this->mockService->expects($this->once())
                ->method('soapClientCall')
                ->with($this->equalTo('United States'),$this->equalTo('New york'))
                ->will($this->returnValue($weatherarray));

        $this->mockController->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('AppBundle:Demo:index.html.twig'),
                $this->equalTo(
                    array(
                        'weather' => $weatherarray
                    )
                ));

        $this->mockController->indexAction($this->mockRequest);
    }

     /**
     * test case for api call if post values are not there
     *
     * @covers AppBundle\Controller\DemoController::indexAction
     */
    public function testindexActionPostFails()
    {

        $defaultData = array('message' => 'Enter City Name Or Country Name For Weather');

        $this->mockController->expects($this->once())
                ->method('createFormBuilder')
                ->with($this->equalTo($defaultData))
                ->will($this->returnValue($this->mockFormBuilder));

        $this->mockFormBuilder->expects($this->at(0))
                ->method('add')
                ->with($this->equalTo('countryname'), $this->equalTo('text'))
                ->will($this->returnValue($this->mockFormBuilder));

        $this->mockFormBuilder->expects($this->at(1))
                ->method('add')
                ->with($this->equalTo('cityname'), $this->equalTo('text'))
                ->will($this->returnValue($this->mockFormBuilder));

        $this->mockFormBuilder->expects($this->at(2))
                ->method('add')
                ->with($this->equalTo('search'), $this->equalTo('submit'))
                ->will($this->returnValue($this->mockFormBuilder));

        $this->mockFormBuilder->expects($this->once())
                ->method('getForm')
                ->will($this->returnValue($this->mockForm));

        $this->mockRequest->expects($this->once())
            ->method('isMethod')
            ->with($this->equalTo('POST'))
            ->will($this->returnValue(false));

        $this->mockController->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('AppBundle:Demo:show.html.twig'),
                $this->equalTo(
                    array(
                        'form' => ''
                    )
                ));

        $this->mockController->indexAction($this->mockRequest);
    }
}
