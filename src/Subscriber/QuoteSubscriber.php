<?php

namespace App\Subscriber;

use App\Event\QuoteCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class QuoteSubscriber implements EventSubscriberInterface
{
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
    }
}
