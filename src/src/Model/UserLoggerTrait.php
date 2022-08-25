<?php

namespace App\Model;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

trait UserLoggerTrait {

    #[ORM\ManyToOne(targetEntity: 'App\Entity\User')]
    protected $createdBy;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\User')]
    protected $updatedBy;

    public function getCreatedBy():User{
        return $this->createdBy;
    }

    public function setCreatedBy(?User $user): self{
        $this->createdBy = $user;

        return $this;
    }

    public function getUpdatedBy(): User{
        return $this->updatedBy;
    }

    public function setUpdatedBy(?User $user): self{
        $this->updatedBy = $user;

        return $this;
    }
}