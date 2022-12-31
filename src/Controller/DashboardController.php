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
        $trades = $this->tradeRepository->findBy(['userId' => $this->security->getUser()->getId()], ['exitDateTime' => 'ASC']);
        $strategies = $this->strategyRepository->findByUserId($this->security->getUser()->getId());

        $trade = new Trade();
        $form2 = $this->createForm(TradeType::class, $trade);
        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {
            $trade->setUserId($this->security->getUser()->getId());
            $this->tradeRepository->add($trade, true);

            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'trades' => $trades,
            'strategies' => $strategies,
            'strategyForm' => $form->createView(),
            'tradeForm'=> $form2->createView()
        ], $response);
    }
}
