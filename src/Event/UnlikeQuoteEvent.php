<?php

namespace App\Event;

use App\Entity\Quote;
use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UnlikeQuoteEvent extends Event
{
    protected $quote;
    protected $user;

    public function __construct(Quote $quote, User $user)
    {
        $this->quote = $quote;
        $this->user = $user;
    }

    public function getQuote()
    {
        return $this->quote;
    }

    public function getUser()
    {
        return $this->user;
    }
}
