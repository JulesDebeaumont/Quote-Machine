<?php

namespace App\Event;

use App\Entity\Quote;
use Symfony\Contracts\EventDispatcher\Event;

class QuoteCreatedEvent extends Event
{
    protected $quote;

    public function __construct(Quote $quote)
    {
        $this->quote = $quote;
    }

    public function getQuote()
    {
        return $this->quote;
    }
}
