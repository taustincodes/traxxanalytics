<?php

namespace App\Service;

use App\Repository\TradeRepository;

class TradeService
{
    private $tradeRepository;

    public function __construct(TradeRepository $tradeRepository)
    {
        $this->tradeRepository = $tradeRepository;
    }

    public function removeStrategy(int $strategyId): void
    {
        $this->tradeRepository->removeStrategy($strategyId);
    }
}
