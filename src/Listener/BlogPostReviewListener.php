<?php

namespace App\Listener;

use Symfony\Component\Workflow\Event\GuardEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BlogPostReviewListener implements EventSubscriberInterface
{
    public function guardReview(GuardEvent $event)
    {
        /** @var \App\Entity\BlogPost $post */
        $post = $event->getSubject();

        if (empty($post->getTitle())) {
            // Posts with no title should not be allowed
            $event->setBlocked(true);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'workflow.blogpost.guard.to_review' => ['guardReview'],
        ];
    }
}