<?php

namespace App\Entity;

use App\Model\TimeLoggerInterface;
use App\Model\TimeLoggerTrait;
use App\Model\UserLoggerInterface;
use App\Model\UserLoggerTrait;
use App\Repository\ContractRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContractRepository::class)]
class Contract implements TimeLoggerInterface, UserLoggerInterface
{
    use TimeLoggerTrait;
    use UserLoggerTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $owneredBy = null;

    #[ORM\Column]
    private ?int $numberOfPropery = null;

    #[ORM\OneToMany(mappedBy: 'contract', targetEntity: Property::class,  orphanRemoval: true)]
    private Collection $properties;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwneredBy(): ?User
    {
        return $this->owneredBy;
    }

    public function setOwneredBy(?User $owneredBy): self
    {
        $this->owneredBy = $owneredBy;

        return $this;
    }

    public function getNumberOfPropery(): ?int
    {
        return $this->numberOfPropery;
    }

    public function setNumberOfPropery(int $numberOfPropery): self
    {
        $this->numberOfPropery = $numberOfPropery;

        return $this;
    }

    /**
     * @return Collection<int, Property>
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Property $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties->add($property);
            $property->setContract($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        if ($this->properties->removeElement($property)) {
            // set the owning side to null (unless already changed)
            if ($property->getContract() === $this) {
                $property->setContract(null);
            }
        }

        return $this;
    }
}
