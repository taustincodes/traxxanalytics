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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class DashboardController extends AbstractController
{
    private $tradeRepository;
    private $security;
    private $strategyRepository;

    public function __construct(
        TradeRepository $tradeRepository,
        Security $security,
        StrategyRepository $strategyRepository
    ) {
        $this->tradeRepository = $tradeRepository;
        $this->security = $security;
        $this->strategyRepository = $strategyRepository;
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
        $trades = $this->tradeRepository->findByUserId($this->security->getUser()->getId());
        $strategies = $this->strategyRepository->findByUserId($this->security->getUser()->getId());
        foreach ($strategies as $key => $strategy) {
            $strategies[$key] = $this->tradeRepository->findBy(['strategy' => $strategy]);
        }
        dd($strategies);

        
        // var_dump($trades);die();
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'trades' => $trades,
            'strategies' => $strategies,
            'form' => $form->createView()
        // ]);
        ], $response);
    }
}
