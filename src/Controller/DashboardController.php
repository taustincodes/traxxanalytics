<?php

namespace App\Controller;

use App\Entity\Strategy;
use App\Entity\Trade;
use App\Form\StrategyType;
use App\Form\TradeType;
use App\Repository\StrategyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TradeRepository;
use App\Service\TradeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

use function PHPSTORM_META\map;

class DashboardController extends AbstractController
{
    private $tradeRepository;
    private $security;
    private $strategyRepository;
    private TradeService $tradeService;

    public function __construct(
        TradeRepository $tradeRepository,
        Security $security,
        StrategyRepository $strategyRepository,
        TradeService $tradeService
    ) {
        $this->tradeRepository = $tradeRepository;
        $this->security = $security;
        $this->strategyRepository = $strategyRepository;
        $this->tradeService = $tradeService;
    }

    /**
     * @Route("/dashboard", name="app_index")
     */
    public function index(Request $request): Response
    {
        $strategy = new Strategy();
        $form = $this->createForm(StrategyType::class, $strategy);
        $form->handleRequest($request);
        $response = new Response(null, $form->isSubmitted() ? 422 : 200);
        if ($form->isSubmitted() && $form->isValid()) {
            $strategy->setUserId($this->security->getUser()->getId());
            $this->strategyRepository->add($strategy, true);
            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        //TODO: get trades in order of exit date descending
        // $trades = $this->tradeRepository->findByUserId($this->security->getUser()->getId());
        $trades = $this->tradeRepository->findBy(['userId' => $this->security->getUser()->getId()], ['exitDateTime' => 'ASC']);
        // $strategies = $this->strategyRepository->findByUserId($this->security->getUser()->getId());
        $strategies = $this->strategyRepository->findByUserId($this->security->getUser()->getId());
        $strategiesChartData = [
            'categories' => [],
            'data' => []
        ];

        //Change to success ratio
        foreach ($strategies as $key => $strategy) {
            $strategyTrades = $this->tradeRepository->findBy(['strategy' => $strategy]);
            $positiveTrades = 0;
            $negativeTrades = 0;
            foreach ($strategyTrades as $trade) {
                if ($trade->getPercentageProfit() > 0) {
                    $positiveTrades++;
                } else {
                    $negativeTrades++;
                }
            }
            if ($positiveTrades || $negativeTrades) {
                $successPercentage = ($positiveTrades / ($positiveTrades + $negativeTrades)) * 100;
                array_push($strategiesChartData['data'], floatval(number_format($successPercentage, 2)));
                array_push($strategiesChartData['categories'], $strategy->getName());
            }
        }

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'trades' => $trades,
            'strategies' => $strategies,
            'strategiesChartData' => $strategiesChartData,
            'form' => $form->createView()
        // ]);
        ], $response);
    }
}
