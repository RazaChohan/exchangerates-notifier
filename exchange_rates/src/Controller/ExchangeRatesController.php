<?php
namespace App\Controller;
use App\Entity\ExchangeRate;
use App\Utilities\CurlHelper;
use App\Utilities\ThirdPartyApi;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
        $repository = $this->getDoctrine()->getRepository(ExchangeRate::class);
        $exchangeRates = [];//$repository->where('');
        if(empty($exchangeRates)) {
            $exchangeRates = $this->thirdPartyApi->getExchangeRates($baseCurrency);
            //insert in DB
            $em = $this->getDoctrine()->getManager();
            foreach ($exchangeRates as $exchangeRate) {
                $em->persist($exchangeRate);
            }
            $em->flush();
        }

        return $this->handleView($this->view($exchangeRates));
    }
}