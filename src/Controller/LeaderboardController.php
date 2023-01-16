<?php

namespace App\Controller;

use App\Repository\TradeRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LeaderboardController extends AbstractController
{
    private TradeRepository $tradeRepository;

    public function __construct(TradeRepository $tradeRepository)
    {
        $this->tradeRepository = $tradeRepository;
    }

    /**
     * @Route("/leaderboard", name="app_leaderboard")
     */
    public function index(): Response
    {
        $one = new DateTime('first day of this year');
        $two = new DateTime('now');

    

        $trades = $this->tradeRepository->getMaxProfitTradePerUser($one, $two);
        $topTrades = [];
        foreach ($trades as $trade) {
            if (!array_key_exists($trade->getUser()->getEmail(), $topTrades)) {
                $topTrades[$trade->getUser()->getEmail()] = $trade->getPercentageProfit();
            } elseif ($trade->getPercentageProfit() > $topTrades[$trade->getUser()->getEmail()]) {
                $topTrades[$trade->getUser()->getEmail()] = $trade->getPercentageProfit();
            }
        }
        
        return $this->render('leaderboard/index.html.twig', [
            'controller_name' => 'LeaderboardController',
            'topTrades' => $topTrades
        ]);
    }
}
