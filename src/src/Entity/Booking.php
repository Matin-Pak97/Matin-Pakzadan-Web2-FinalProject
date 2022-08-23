<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $bookedBy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookedBy(): ?User
    {
        return $this->bookedBy;
    }

    public function setBookedBy(?User $bookedBy): self
    {
        $this->bookedBy = $bookedBy;

        return $this;
    }
}
