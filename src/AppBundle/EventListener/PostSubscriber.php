<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\Post;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class PostSubscriber implements EventSubscriber
{
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
        /** @var Post $entity */
        $entity = $args->getObject();
        if ($entity instanceof Post) {
            $entity->setUpdatedAt(new \DateTime('now'));
        }
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        /** @var Post $entity */
        $entity = $args->getObject();
        if ($entity instanceof Post) {
            $entity->setCreatedAt(new \DateTime('now'));

        }
    }
}