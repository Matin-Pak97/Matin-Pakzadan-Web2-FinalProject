<?php

namespace App\Entity;

use App\Model\TimeLoggerInterface;
use App\Model\TimeLoggerTrait;
use App\Model\UserLoggerInterface;
use App\Model\UserLoggerTrait;
use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking implements TimeLoggerInterface, UserLoggerInterface
{
    use TimeLoggerTrait;
    use UserLoggerTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $bookedBy = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Property $property = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?RatePlan $ratePlan = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $bookingStartDate = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $bookingEndDate = null;

    #[ORM\Column]
    private ?int $numberOfGuest = null;

    #[ORM\Column(nullable: true)]
    private ?int $extraGuestTotalPrice = null;

    #[ORM\Column(nullable: true)]
    private ?int $totalBookingPrice = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

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

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function getRatePlan(): ?RatePlan
    {
        return $this->ratePlan;
    }

    public function setRatePlan(?RatePlan $ratePlan): self
    {
        $this->ratePlan = $ratePlan;

        return $this;
    }

    public function getBookingStartDate(): ?\DateTimeImmutable
    {
        return $this->bookingStartDate;
    }

    public function setBookingStartDate(\DateTimeImmutable $bookingStartDate): self
    {
        $this->bookingStartDate = $bookingStartDate;

        return $this;
    }

    public function getBookingEndDate(): ?\DateTimeImmutable
    {
        return $this->bookingEndDate;
    }

    public function setBookingEndDate(\DateTimeImmutable $bookingEndDate): self
    {
        $this->bookingEndDate = $bookingEndDate;

        return $this;
    }

    public function getNumberOfGuest(): ?int
    {
        return $this->numberOfGuest;
    }

    public function setNumberOfGuest(int $numberOfGuest): self
    {
        $this->numberOfGuest = $numberOfGuest;

        return $this;
    }

    public function getExtraGuestTotalPrice(): ?int
    {
        return $this->extraGuestTotalPrice;
    }

    public function setExtraGuestTotalPrice(?int $extraGuestTotalPrice): self
    {
        $this->extraGuestTotalPrice = $extraGuestTotalPrice;

        return $this;
    }

    public function getTotalBookingPrice(): ?int
    {
        return $this->totalBookingPrice;
    }

    public function setTotalBookingPrice(?int $totalBookingPrice): self
    {
        $this->totalBookingPrice = $totalBookingPrice;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
