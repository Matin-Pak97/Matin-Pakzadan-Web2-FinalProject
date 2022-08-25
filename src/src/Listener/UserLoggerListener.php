<?php

namespace App\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use App\Model\UserLoggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserLoggerListener
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }


    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof UserLoggerInterface) {
            return;
        }

        $token = $this->tokenStorage->getToken();
        $user = $token == null ? null : $this->tokenStorage->getToken()->getUser();

        $entity->setCreatedBy($user);
        $entity->setUpdatedBy($user);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof UserLoggerInterface) {
            return;
        }

        $token = $this->tokenStorage->getToken();
        $user = $token == null ? null : $this->tokenStorage->getToken()->getUser();

        $entity->setUpdatedBy($user);
    }
}