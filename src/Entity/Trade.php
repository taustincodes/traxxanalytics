<?php

namespace App\Entity;

use App\Repository\TradeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TradeRepository::class)
 */
class Trade
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $userId;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $entryPrice;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $exitPrice;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $market;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getEntryPrice(): ?float
    {
        return $this->entryPrice;
    }

    public function setEntryPrice(?float $entryPrice): self
    {
        $this->entryPrice = $entryPrice;

        return $this;
    }

    public function getExitPrice(): ?float
    {
        return $this->exitPrice;
    }

    public function setExitPrice(?float $exitPrice): self
    {
        $this->exitPrice = $exitPrice;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getMarket(): ?string
    {
        return $this->market;
    }

    public function setMarket(?string $market): self
    {
        $this->market = $market;

        return $this;
    }
}
