<?php

namespace App\Subscriber;

use App\Event\QuoteCreatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class QuoteSubscriber implements EventSubscriberInterface
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            QuoteCreatedEvent::class => 'onQuoteCreate',
        ];
    }

    public function onQuoteCreate(QuoteCreatedEvent $event): void
    {
        $userExperience = $event->getQuote()->getAuthor()->getExperience();
        $quoteCategory = $event->getQuote()->getCategory();
        $userQuotes = $event->getQuote()->getAuthor()->getQuotes();
        $firstInCategory = true;

        //TO DO chopper catégorie dans userQuote
        foreach ($userQuotes as $userQuote) {
            if ($userQuote->getCategory() === $quoteCategory) {
                $firstInCategory = false;
            }
        }

        $firstInCategory === false
            ?
            $event->getQuote()->getAuthor()->setExperience($userExperience + 100)
            :
            $event->getQuote()->getAuthor()->setExperience($userExperience + 120);

        $this->manager->flush();
    }
}
