<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class PostSubscriber implements EventSubscriber
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * PostSubscriber constructor.
     * @param TokenStorage $tokenStorage
     */
    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            'prePersist',
            'preUpdate',
        ];
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        /** @var Post $entity */
        $entity = $args->getObject();
        if ($entity instanceof Post) {
            $entity->setUpdatedAt(new \DateTime('now'));
            $entity->setUpdater($user);
        }
        if ($entity instanceof Comment) {
            $entity->setUpdatedAt(new \DateTime('now'));
        }
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        /** @var Post $entity */
        $entity = $args->getObject();
        if ($entity instanceof Post) {
            $entity->setCreatedAt(new \DateTime('now'));
            $entity->setUsers($user);

        }
        if ($entity instanceof Comment) {
            $entity->setCreatedAt(new \DateTime('now'));
        }
    }
}