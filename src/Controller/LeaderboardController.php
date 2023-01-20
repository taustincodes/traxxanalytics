<?php

namespace App\Controller;

use App\Repository\TradeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

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

        $topTrades = [];
        $oldestTrade = $this->tradeRepository->getOldestTrade();
        $startDate = new DateTime('first day of this month');
        $endDate = new DateTime('last day of this month');

        while (!($startDate <= $oldestTrade->getExitDateTime())) {
            $currentMonth = $startDate->format('F');
            $data = [];
            $trades = $this->tradeRepository->getMaxProfitTradePerUser($startDate, $endDate);
            foreach ($trades as $trade) {
                if (!$trade->getUser()->getIsPrivate()) {
                    if (!array_key_exists($trade->getUser()->getEmail(), $data)) {
                        $data[$trade->getUser()->getUsername()] = number_format($trade->getPercentageProfit(), 2);
                    } elseif ($trade->getPercentageProfit() > $data[$trade->getUser()->getEmail()]) {
                        $data[$trade->getUser()->getUsername()] = number_format($trade->getPercentageProfit(), 2);
                    }
                }
            }
            if ($data) {
                $topTrades[$currentMonth] = $data;
            }
            $startDate->modify('first day of last month');
            $endDate->modify('last day of last month');
        }
        return $this->render('leaderboard/index.html.twig', [
            'controller_name' => 'LeaderboardController',
            'topTrades' => $topTrades
        ]);
    }
}
