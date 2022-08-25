<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;

trait TimeLoggerTrait
{
    #[ORM\Column(type: 'datetime_immutable')]
    protected $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    protected $updatedAt;


    public function getCreatedAt(): \DateTimeImmutable{
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self{
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable{
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self{
        $this->updatedAt = $updatedAt;

        return $this;
    }
}