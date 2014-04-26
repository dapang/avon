<?php
namespace Iqiyi\AvonBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Iqiyi\AvonBundle\Entity\AvonSubjectVote;

class UpdateVoteNumber
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();

        if ($entity instanceof AvonSubjectVote && $entity->getSubjectId())
        {
            $object = $em->getRepository('IqiyiAvonBundle:AvonSubject')
            					->find($entity->getSubjectId());
            if($object){
                $curVote = $object->getTotalVote();
                $curVote++;
            	$object->setTotalVote($curVote);
            	$em->persist($object);
            	$em->flush();
            }
        }
    }
}
?>