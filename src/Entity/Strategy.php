<?php

namespace App\Entity;

use App\Repository\StrategyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StrategyRepository::class)
 */
class Strategy
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="strategies")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Trade::class, mappedBy="strategy")
     */
    private $trades;

    public function __construct()
    {
        $this->trades = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setuser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
    
    public function getSuccessPercentage()
    {
        $positiveTrades = 0;
        $negativeTrades = 0;
        $trades = $this->trades;
        foreach ($trades as $trade) {
            if ($trade->getPercentageProfit() >= 0) {
                $positiveTrades++;
            } else {
                $negativeTrades++;
            }
        }
        if ($positiveTrades || $negativeTrades) {
            $successPercentage = ($positiveTrades / ($positiveTrades + $negativeTrades)) * 100;
            return $successPercentage;
        }
    }

    // /**
    //  * @return Collection<int, Trade>
    //  */
    // public function getTrades(): Collection
    // {
    //     return $this->trades;
    // }

    // public function addTrade(Trade $trade): self
    // {
    //     if (!$this->trades->contains($trade)) {
    //         $this->trades[] = $trade;
    //         $trade->setStrategy($this);
    //     }

    //     return $this;
    // }

    // public function removeTrade(Trade $trade): self
    // {
    //     if ($this->trades->removeElement($trade)) {
    //         // set the owning side to null (unless already changed)
    //         if ($trade->getStrategy() === $this) {
    //             $trade->setStrategy(null);
    //         }
    //     }

    //     return $this;
    // }
}
