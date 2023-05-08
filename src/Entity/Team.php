<?php

namespace App\Entity;

use App\Entity\Country;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column]
    private ?int $MoneyBalance = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateCreated = null;

    #[ORM\OneToMany(mappedBy: 'Team', targetEntity: Player::class)]
    private Collection $MyPlayers;

    #[ORM\OneToMany(mappedBy: 'Buyer', targetEntity: SellPlayer::class)]
    private Collection $TeamSales;

    #[ORM\OneToMany(mappedBy: 'Team', targetEntity: BuyPlayer::class)]
    private Collection $TeamPurchases;

    #[ORM\ManyToOne(targetEntity: "App\Entity\Country")]
    #[ORM\JoinColumn(nullable: false)]
    private $country;


    public function __construct()
    {
        $this->MyPlayers = new ArrayCollection();
        $this->TeamSales = new ArrayCollection();
        $this->TeamPurchases = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getMoneyBalance(): ?int
    {
        return $this->MoneyBalance;
    }

    public function setMoneyBalance(int $MoneyBalance): self
    {
        $this->MoneyBalance = $MoneyBalance;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->DateCreated;
    }

    public function setDateCreated(\DateTimeInterface $DateCreated): self
    {
        $this->DateCreated = $DateCreated;

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getMyPlayers(): Collection
    {
        return $this->MyPlayers;
    }

    public function addMyPlayer(Player $myPlayer): self
    {
        if (!$this->MyPlayers->contains($myPlayer)) {
            $this->MyPlayers->add($myPlayer);
            $myPlayer->setTeam($this);
        }

        return $this;
    }

    public function removeMyPlayer(Player $myPlayer): self
    {
        if ($this->MyPlayers->removeElement($myPlayer)) {
            // set the owning side to null (unless already changed)
            if ($myPlayer->getTeam() === $this) {
                $myPlayer->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SellPlayer>
     */
    public function getTeamSales(): Collection
    {
        return $this->TeamSales;
    }

    public function addTeamSale(SellPlayer $teamSale): self
    {
        if (!$this->TeamSales->contains($teamSale)) {
            $this->TeamSales->add($teamSale);
            $teamSale->setBuyer($this);
        }

        return $this;
    }

    public function removeTeamSale(SellPlayer $teamSale): self
    {
        if ($this->TeamSales->removeElement($teamSale)) {
            // set the owning side to null (unless already changed)
            if ($teamSale->getBuyer() === $this) {
                $teamSale->setBuyer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BuyPlayer>
     */
    public function getTeamPurchases(): Collection
    {
        return $this->TeamPurchases;
    }

    public function addTeamPurchase(BuyPlayer $teamPurchase): self
    {
        if (!$this->TeamPurchases->contains($teamPurchase)) {
            $this->TeamPurchases->add($teamPurchase);
            $teamPurchase->setTeam($this);
        }

        return $this;
    }

    public function removeTeamPurchase(BuyPlayer $teamPurchase): self
    {
        if ($this->TeamPurchases->removeElement($teamPurchase)) {
            // set the owning side to null (unless already changed)
            if ($teamPurchase->getTeam() === $this) {
                $teamPurchase->setTeam(null);
            }
        }

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

     
}
