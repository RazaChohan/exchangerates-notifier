<?php
namespace App\Controller;
use App\Entity\ExchangeRate;
use App\Utilities\ThirdPartyApi;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zend\XmlRpc\Server;

/**
 * Exchange Rates controller.
 * @Route("/api", name="api_")
 */
class ExchangeRatesController extends FOSRestController
{
    /**
     * @var ThirdPartyApi
     */
    private $thirdPartyApi;

    /***
     * ExchangeRatesController constructor.
     */
    public function __construct()
    {
        $this->thirdPartyApi = new ThirdPartyApi();
    }

    /**
     * Lists Exchange rates.
     * @Rest\Get("/exchange-rates")
     *
     * @param $request
     * @return Response
     */
    public function getExchangeRate(Request $request)
    {
        $baseCurrency = $request->get('base', 'USD');
        $date = $request->get('date', date('Y-m-d'));
        $exchangeRates = $this->getExchangeRates($baseCurrency, $date);

        return $this->handleView($this->view($exchangeRates));
    }
    /***
     *
     * Xml Rpc handler
     *
     * @return Response
     */
    public function xmlRpcHandler()
    {
        $server = new Server;
        $server->setClass($this->get('App\Controller\ExchangeRatesController'));

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');
        ob_start();
        $server->handle();
        $response->setContent(ob_get_clean());
        return $response;
    }

    /***
     * Xml Rpc get exchange rates
     *
     * @return array
     */
    public function getExchangeRateXmlRpc()
    {
        return $this->getExchangeRates('EUR', date('Y-m-d'));
    }

    /***
     * Get exchange rates from DB or API
     *
     * @param $baseCurrency
     * @param $date
     *
     * @return array
     */
    private function getExchangeRates($baseCurrency, $date)
    {
        $repository = $this->getDoctrine()->getRepository(ExchangeRate::class);
        $exchangeRates = $repository->findAllExchangeRatesByFilters($baseCurrency, $date);
        if(empty($exchangeRates)) {
            $exchangeRates = $this->thirdPartyApi->getExchangeRates("EUR", date('Y-m-d'));
            //insert in DB
            $em = $this->getDoctrine()->getManager();
            foreach ($exchangeRates as $exchangeRate) {
                $em->persist($exchangeRate);
            }
            $em->flush();
        };
        return $exchangeRates;
    }
}
