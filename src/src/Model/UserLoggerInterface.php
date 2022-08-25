<?php

namespace App\Model;

use App\Entity\User;

interface UserLoggerInterface {
    public function getCreatedBy(): User;
    public function setCreatedBy(User $user): self;

    public function getUpdatedBy(): User;
    public function setUpdatedBy(User $user): self;
}