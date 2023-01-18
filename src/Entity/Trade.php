<?php

namespace App\Entity;

use App\Repository\TradeRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass=TradeRepository::class)
 */
class Trade
{
    const side_buy = 'BUY';
    const side_sell = 'SELL';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="trades")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $side;

    /**
     * @ORM\Column(type="datetime")
     */
    private $entryDateTime;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $exitDateTime;

    /**
     * @ORM\Column(type="float")
     */
    private $leverage = 1;

    /**
     * @ORM\ManyToOne(targetEntity=Strategy::class, inversedBy="trades")
     */
    private $strategy;

    public function getPercentageProfit()
    {   
        if ($this->side == self::side_buy) {
            return (($this->exitPrice - $this->entryPrice) / $this->entryPrice * 100) * $this->leverage;
        } else {
            return (($this->entryPrice - $this->exitPrice) / $this->exitPrice * 100) * $this->leverage;
        }
    }

    public function getPNL()
    {
        return $this->getAmount() * ($this->getPercentageProfit() / 100);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getuser(): ?User
    {
        return $this->user;
    }

    public function setuser(?User $user): self
    {
        $this->user = $user;

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

    public function getSide(): ?string
    {
        return $this->side;
    }

    public function setSide(string $side): self
    {
        $this->side = $side;

        return $this;
    }

    public function getEntryDateTime(): ?\DateTimeInterface
    {
        return $this->entryDateTime;
    }

    public function setEntryDateTime(\DateTimeInterface $entryDateTime): self
    {
        $this->entryDateTime = $entryDateTime;

        return $this;
    }

    public function getExitDateTime(): ?\DateTimeInterface
    {
        return $this->exitDateTime;
    }

    public function setExitDateTime(?\DateTimeInterface $exitDateTime): self
    {
        $this->exitDateTime = $exitDateTime;

        return $this;
    }

    public function getLeverage(): ?float
    {
        return $this->leverage;
    }

    public function setLeverage(float $leverage): self
    {
        $this->leverage = $leverage;

        return $this;
    }

    public function getStrategy(): ?Strategy
    {
        return $this->strategy;
    }

    public function setStrategy(?Strategy $strategy): self
    {
        $this->strategy = $strategy;

        return $this;
    }
}
