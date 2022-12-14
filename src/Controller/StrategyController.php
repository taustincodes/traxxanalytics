<?php

namespace App\Controller;

use App\Entity\Strategy;
use App\Repository\StrategyRepository;
use App\Service\TradeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/strategy")
 */
class StrategyController extends AbstractController
{
    private $strategyRepository;
    private $tradeService;

    public function __construct(StrategyRepository $strategyRepository, TradeService $tradeService)
    {
        $this->strategyRepository = $strategyRepository;
        $this->tradeService = $tradeService;
    }

    /**
     * @Route("/{id}", name="app_strategy_delete", methods={"POST"})
     */
    public function delete(Request $request, Strategy $strategy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$strategy->getId(), $request->request->get('_token'))) {
            $this->tradeService->removeStrategy($strategy->getId());
            $this->strategyRepository->remove($strategy, true);
        }

        return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
    }

}