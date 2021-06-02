<?php

namespace App\Subscriber;

use App\Event\QuoteCreatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class QuoteSubscriber implements EventSubscriberInterface
{
    private $manager;
    public const QUOTE_CREATED_EXP = 100;
    public const QUOTE_CREATED_FIRST_TIME_CATEGORY_EXP = 120;

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
            $event->getQuote()->getAuthor()->setExperience($userExperience + self::QUOTE_CREATED_EXP)
            :
            $event->getQuote()->getAuthor()->setExperience($userExperience + self::QUOTE_CREATED_FIRST_TIME_CATEGORY_EXP);

        $this->manager->flush();
    }
}
