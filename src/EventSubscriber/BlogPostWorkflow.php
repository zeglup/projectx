<?php
/**
 * Created by PhpStorm.
 * User: Glup
 * Date: 17/12/2018
 * Time: 14:20
 */

namespace App\EventSubscriber;


use App\Entity\BlogPost;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Workflow\Event\GuardEvent;
use Symfony\Component\Workflow\Registry;

class BlogPostWorkflow implements EventSubscriberInterface
{
    private $workflows;
    private $logger;

    public function __construct(LoggerInterface $logger, Registry $workflows)
    {

        $this->workflows = $workflows;
        $this->logger = $logger;
    }

    public function onLeave(GenericEvent $event)
    {
        $subject = $event->getSubject();
        if (!($subject instanceof BlogPost)){
            return;
        }
        $workflow = $this->workflows->get($subject);

//        $this->logger->info(sprintf(
//            'transaction "%s" "%s"',
//            implode(', ', array_keys($workflow->getMarking($subject)->getPlaces())),
//            implode(', ', array_keys($workflow->getEnabledTransitions($subject)))
//        ));


    }

    public function guardReview(GuardEvent $event)
    {
        /** @var \App\Entity\BlogPost $post */
        $post = $event->getSubject();
        $title = $post->getTitle();

        if (empty($title)) {
            // Posts with no title should not be allowed
            $event->setBlocked(true);
        }
    }


    public static function getSubscribedEvents()
    {
        return array(
            'easy_admin.pre_persist' => array('onLeave'),
            'easy_admin.pre_update' => array('onLeave'),
            'workflow.blogpost.guard.to_review' => array('guardReview'),
        );
    }
}