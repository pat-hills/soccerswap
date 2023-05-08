<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Surname = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $PriceTag = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateCreated = null;

    #[ORM\ManyToOne(inversedBy: 'MyPlayers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $Team = null;

    #[ORM\OneToMany(mappedBy: 'Player', targetEntity: SellPlayer::class)]
    private Collection $SoldPlayers;

    #[ORM\OneToMany(mappedBy: 'Player', targetEntity: BuyPlayer::class)]
    private Collection $BoughtPlayers;

    public function __construct()
    {
        $this->SoldPlayers = new ArrayCollection();
        $this->BoughtPlayers = new ArrayCollection();
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

    public function getSurname(): ?string
    {
        return $this->Surname;
    }

    public function setSurname(string $Surname): self
    {
        $this->Surname = $Surname;

        return $this;
    }

    public function getPriceTag(): ?string
    {
        return $this->PriceTag;
    }

    public function setPriceTag(string $PriceTag): self
    {
        $this->PriceTag = $PriceTag;

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

    public function getTeam(): ?Team
    {
        return $this->Team;
    }

    public function setTeam(?Team $Team): self
    {
        $this->Team = $Team;

        return $this;
    }

    /**
     * @return Collection<int, SellPlayer>
     */
    public function getSoldPlayers(): Collection
    {
        return $this->SoldPlayers;
    }

    public function addSoldPlayer(SellPlayer $soldPlayer): self
    {
        if (!$this->SoldPlayers->contains($soldPlayer)) {
            $this->SoldPlayers->add($soldPlayer);
            $soldPlayer->setPlayer($this);
        }

        return $this;
    }

    public function removeSoldPlayer(SellPlayer $soldPlayer): self
    {
        if ($this->SoldPlayers->removeElement($soldPlayer)) {
            // set the owning side to null (unless already changed)
            if ($soldPlayer->getPlayer() === $this) {
                $soldPlayer->setPlayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BuyPlayer>
     */
    public function getBoughtPlayers(): Collection
    {
        return $this->BoughtPlayers;
    }

    public function addBoughtPlayer(BuyPlayer $boughtPlayer): self
    {
        if (!$this->BoughtPlayers->contains($boughtPlayer)) {
            $this->BoughtPlayers->add($boughtPlayer);
            $boughtPlayer->setPlayer($this);
        }

        return $this;
    }

    public function removeBoughtPlayer(BuyPlayer $boughtPlayer): self
    {
        if ($this->BoughtPlayers->removeElement($boughtPlayer)) {
            // set the owning side to null (unless already changed)
            if ($boughtPlayer->getPlayer() === $this) {
                $boughtPlayer->setPlayer(null);
            }
        }

        return $this;
    }
}
