<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numero = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $rue = null;

    #[ORM\Column]
    private ?int $code_postal = null;

    #[ORM\Column]
    private ?bool $type = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $ville = null;

    #[ORM\ManyToOne(inversedBy: 'adresses')]
    private ?Profile $profile = null;

    #[ORM\OneToMany(mappedBy: 'shippingAdresse', targetEntity: Order::class)]
    private Collection $shippingAdresse;

    #[ORM\OneToMany(mappedBy: 'billingAdresse', targetEntity: Order::class)]
    private Collection $billingAdresse;



    public function __construct()
    {
        $this->shippingAdresse = new ArrayCollection();
        $this->billingAdresse = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): static
    {
        $this->rue = $rue;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    public function setCodePostal(int $code_postal): static
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function isType(): ?bool
    {
        return $this->type;
    }

    public function setType(bool $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): static
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getShippingAdresse(): Collection
    {
        return $this->shippingAdresse;
    }

    public function addShippingAdresse(Order $shippingAdresse): static
    {
        if (!$this->shippingAdresse->contains($shippingAdresse)) {
            $this->shippingAdresse->add($shippingAdresse);
            $shippingAdresse->setShippingAdresse($this);
        }

        return $this;
    }

    public function removeShippingAdresse(Order $shippingAdresse): static
    {
        if ($this->shippingAdresse->removeElement($shippingAdresse)) {
            // set the owning side to null (unless already changed)
            if ($shippingAdresse->getShippingAdresse() === $this) {
                $shippingAdresse->setShippingAdresse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getBillingAdresse(): Collection
    {
        return $this->billingAdresse;
    }

    public function addBillingAdresse(Order $billingAdresse): static
    {
        if (!$this->billingAdresse->contains($billingAdresse)) {
            $this->billingAdresse->add($billingAdresse);
            $billingAdresse->setBillingAdresse($this);
        }

        return $this;
    }

    public function removeBillingAdresse(Order $billingAdresse): static
    {
        if ($this->billingAdresse->removeElement($billingAdresse)) {
            // set the owning side to null (unless already changed)
            if ($billingAdresse->getBillingAdresse() === $this) {
                $billingAdresse->setBillingAdresse(null);
            }
        }

        return $this;
    }





}
