<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'shippingAdresse')]
    private ?Adresse $shippingAdresse = null;

    #[ORM\ManyToOne(inversedBy: 'billingAdresse')]
    private ?Adresse $billingAdresse = null;

    #[ORM\Column]
    private ?int $total = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdat = null;

    #[ORM\OneToMany(mappedBy: 'oforder', targetEntity: OderItem::class)]
    private Collection $oderItems;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Profile $fromUser = null;

    #[ORM\Column(nullable: true)]
    private ?int $statut = null;

    public function __construct()
    {
        $this->oderItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShippingAdresse(): ?Adresse
    {
        return $this->shippingAdresse;
    }

    public function setShippingAdresse(?Adresse $shippingAdresse): static
    {
        $this->shippingAdresse = $shippingAdresse;

        return $this;
    }

    public function getBillingAdresse(): ?Adresse
    {
        return $this->billingAdresse;
    }

    public function setBillingAdresse(?Adresse $billingAdresse): static
    {
        $this->billingAdresse = $billingAdresse;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeInterface $createdat): static
    {
        $this->createdat = $createdat;

        return $this;
    }

    /**
     * @return Collection<int, OderItem>
     */
    public function getOderItems(): Collection
    {
        return $this->oderItems;
    }

    public function addOderItem(OderItem $oderItem): static
    {
        if (!$this->oderItems->contains($oderItem)) {
            $this->oderItems->add($oderItem);
            $oderItem->setOforder($this);
        }

        return $this;
    }

    public function removeOderItem(OderItem $oderItem): static
    {
        if ($this->oderItems->removeElement($oderItem)) {
            // set the owning side to null (unless already changed)
            if ($oderItem->getOforder() === $this) {
                $oderItem->setOforder(null);
            }
        }

        return $this;
    }

    public function getFromUser(): ?Profile
    {
        return $this->fromUser;
    }

    public function setFromUser(?Profile $fromUser): static
    {
        $this->fromUser = $fromUser;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(?int $statut): static
    {
        $this->statut = $statut;

        return $this;
    }
}
