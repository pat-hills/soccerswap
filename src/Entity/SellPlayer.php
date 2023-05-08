<?php

namespace App\Entity;

use App\Repository\SellPlayerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SellPlayerRepository::class)]
class SellPlayer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $PlayerAmount = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $TransactionDate = null;

    #[ORM\ManyToOne(inversedBy: 'SoldPlayers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Player $Player = null;

    #[ORM\ManyToOne(inversedBy: 'TeamSales')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $Buyer = null;

    #[ORM\Column(length: 64)]
    private ?string $Category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayerAmount(): ?string
    {
        return $this->PlayerAmount;
    }

    public function setPlayerAmount(string $PlayerAmount): self
    {
        $this->PlayerAmount = $PlayerAmount;

        return $this;
    }

    public function getTransactionDate(): ?\DateTimeInterface
    {
        return $this->TransactionDate;
    }

    public function setTransactionDate(\DateTimeInterface $TransactionDate): self
    {
        $this->TransactionDate = $TransactionDate;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->Player;
    }

    public function setPlayer(?Player $Player): self
    {
        $this->Player = $Player;

        return $this;
    }

    public function getBuyer(): ?Team
    {
        return $this->Buyer;
    }

    public function setBuyer(?Team $Buyer): self
    {
        $this->Buyer = $Buyer;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->Category;
    }

    public function setCategory(string $Category): self
    {
        $this->Category = $Category;

        return $this;
    }
}
