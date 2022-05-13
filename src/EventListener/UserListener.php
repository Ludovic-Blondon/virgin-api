<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListener
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    /** @ORM\PrePersist */
    public function prePersistHandler(User $entity, LifecycleEventArgs $event)
    {
        //exit('PrePersist');
        $passwordHashed = $this->passwordHasher->hashPassword(
            $entity,
            $entity->getPassword()
        );

        $entity->setPassword($passwordHashed);
    }

    /** @ORM\PostPersist */
    public function postPersistHandler(User $entity, LifecycleEventArgs $event)
    {
        //exit('PostPersist');
    }

    /** @ORM\PreUpdate */
    public function preUpdateHandler(User $entity, PreUpdateEventArgs $event)
    {
        //exit('PreUpdate');
        $changes = $event->getEntityChangeSet();
        if (isset($changes['password'])) {
            $passwordHashed = $this->passwordHasher->hashPassword(
                $entity,
                $changes['password'][1]
            );

            $entity->setPassword($passwordHashed);
        }
    }

    /** @ORM\PostUpdate */
    public function postUpdateHandler(User $entity, LifecycleEventArgs $event)
    {
        //exit('PostUpdate');
    }

    /** @ORM\PostRemove */
    public function postRemoveHandler(User $entity, LifecycleEventArgs $event)
    {
        //exit('PostRemove');
    }

    /** @ORM\PreRemove */
    public function preRemoveHandler(User $entity, LifecycleEventArgs $event)
    {
        //exit('PreRemove');
    }

    /** @ORM\PreFlush */
    public function preFlushHandler(User $entity, PreFlushEventArgs $event)
    {
        //exit('PreFlush');
    }

    /** @ORM\PostLoad */
    public function postLoadHandler(User $entity, LifecycleEventArgs $event)
    {
        //exit('PostLoad');
    }

}
