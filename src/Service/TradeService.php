<?php

namespace App\Service;

use App\Repository\TradeRepository;
use DateTime;

class TradeService
{
    private TradeRepository $tradeRepository;

    public function __construct(TradeRepository $tradeRepository)
    {
        $this->tradeRepository = $tradeRepository;
    }

    public function removeStrategy(int $strategyId): void
    {
        $this->tradeRepository->removeStrategy($strategyId);
    }

    public function getMaxProfitTradePerUser(DateTime $startDateTime, DateTime $endDateTime): array
    {
        return $this->tradeRepository->getMaxProfitTradePerUser($startDateTime, $endDateTime);
    }
}
