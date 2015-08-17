<?php
/**
 * Handles the soap call for given country name or city name
 *
 * @package AppBundle\Controller
 * @author Ravikumar P S <ravikumarps88@yahoo.co.in>
 */
namespace AppBundle\Controller;

use BeSimple\SoapBundle\ServiceDefinition\Annotation as Soap;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
/**
 * Class DemoController
 *
 * @package AppBundle\Controller
 */
class DemoController extends Controller
{
    /**
     * creates form using createFormBuilder
     * uses BeSimple Bundle for soap api call
     * @return array of weather details
     */
    public function indexAction(Request $request)
    {
        $defaultData = array('message' => 'Enter City Name Or Country Name For Weather');
        $form = $this->createFormBuilder($defaultData)
            ->add('countryname', 'text')
            ->add('cityname', 'text')
            ->add('search', 'submit')
            ->getForm();

        if ($request->isMethod('POST')) {

            $form->bind($request);
            $data = $form->getData();
            $country = $data['countryname'];
            $city = $data['cityname'];

            $soapService = $this->get('api.weather.handler');
            $weatherarray = $soapService->soapClientCall($country,$city);

            return $this->render(
                 'AppBundle:Demo:index.html.twig',
                 array('weather' => $weatherarray)
            );
        }

        return $this->render(
             'AppBundle:Demo:show.html.twig',
             array('form' => $form->createView())
        );

    }

}
