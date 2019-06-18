<?php
namespace App\Controller;
use App\Utilities\CurlHelper;
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
     * @var CurlHelper
     */
    private $curlHelper;

    /***
     * ExchangeRatesController constructor.
     */
    public function __construct()
    {
        $this->curlHelper = new CurlHelper();
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
        return $this->handleView($this->view(['status' => true]));
    }
}