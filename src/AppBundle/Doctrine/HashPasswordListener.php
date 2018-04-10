<?php
/**
 * Created by PhpStorm.
 * User: boran
 * Date: 22.01.17
 * Time: 17:13
 */

namespace AppBundle\Doctrine;


use AppBundle\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class HashPasswordListener implements EventSubscriber
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoder $passwordEncoder)
    {

        $this->passwordEncoder=$passwordEncoder;

    }

    public function getSubscribedEvents()
    {
        return ['prePersist','preUpdate'];
    }
    public function prePersist(LifecycleEventArgs $args){

        $entity=$args->getEntity();
        if(!$entity instanceof User){
            return;
        }

        $encoded=$this->passwordEncoder->encodePassword(
            $entity,
            $entity->getPlainPassword()
        );
        $entity->setPassword($encoded);

    }
    public function preUpdate(LifecycleEventArgs $args){

        $entity=$args->getEntity();
        if(!$entity instanceof User){
            return;
        }

        $encoded=$this->passwordEncoder->encodePassword(
            $entity,
            $entity->getPlainPassword()
        );
        $entity->setPassword($encoded);

        $em = $args->getEntityManager();
        $meta = $em->getClassMetadata(get_class($entity));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);

    }


}