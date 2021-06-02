<?php

namespace App\Subscriber;

use App\Event\UnlikeQuoteEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UnlikeSubscriber implements EventSubscriberInterface
{
    private $manager;
    public const LIKE_QUOTE = 25;
    public const USER_LIKE_OWN_QUOTE = 200;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UnlikeQuoteEvent::class => 'onUnlike',
        ];
    }

    public function onUnlike(UnlikeQuoteEvent $event): void
    {
        $authorExperience = $event->getQuote()->getAuthor()->getExperience();
        $userExperience = $event->getUser()->getExperience();

        $event->getQuote()->getAuthor()->setExperience($authorExperience - self::USER_LIKE_OWN_QUOTE);
        $event->getUser()->setExperience($userExperience - self::LIKE_QUOTE);

        $this->manager->flush();
    }
}
