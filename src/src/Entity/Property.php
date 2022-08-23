<?php

namespace App\Entity;

use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
class Property
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $marketName = null;

    #[ORM\Column]
    private ?int $maxCapacity = null;

    #[ORM\Column]
    private ?int $minCapacity = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $checkinTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $checkoutTime = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PropertyType $type = null;

    #[ORM\OneToMany(mappedBy: 'property', targetEntity: RatePlan::class, orphanRemoval: true)]
    private Collection $ratePlans;

    public function __construct()
    {
        $this->ratePlans = new ArrayCollection();
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

    public function getMarketName(): ?string
    {
        return $this->marketName;
    }

    public function setMarketName(string $marketName): self
    {
        $this->marketName = $marketName;

        return $this;
    }

    public function getMaxCapacity(): ?int
    {
        return $this->maxCapacity;
    }

    public function setMaxCapacity(int $maxCapacity): self
    {
        $this->maxCapacity = $maxCapacity;

        return $this;
    }

    public function getMinCapacity(): ?int
    {
        return $this->minCapacity;
    }

    public function setMinCapacity(int $minCapacity): self
    {
        $this->minCapacity = $minCapacity;

        return $this;
    }

    public function getCheckinTime(): ?\DateTimeInterface
    {
        return $this->checkinTime;
    }

    public function setCheckinTime(?\DateTimeInterface $checkinTime): self
    {
        $this->checkinTime = $checkinTime;

        return $this;
    }

    public function getCheckoutTime(): ?\DateTimeInterface
    {
        return $this->checkoutTime;
    }

    public function setCheckoutTime(?\DateTimeInterface $checkoutTime): self
    {
        $this->checkoutTime = $checkoutTime;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getType(): ?PropertyType
    {
        return $this->type;
    }

    public function setType(?PropertyType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, RatePlan>
     */
    public function getRatePlans(): Collection
    {
        return $this->ratePlans;
    }

    public function addRatePlan(RatePlan $ratePlan): self
    {
        if (!$this->ratePlans->contains($ratePlan)) {
            $this->ratePlans->add($ratePlan);
            $ratePlan->setProperty($this);
        }

        return $this;
    }

    public function removeRatePlan(RatePlan $ratePlan): self
    {
        if ($this->ratePlans->removeElement($ratePlan)) {
            // set the owning side to null (unless already changed)
            if ($ratePlan->getProperty() === $this) {
                $ratePlan->setProperty(null);
            }
        }

        return $this;
    }
}
