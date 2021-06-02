<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Entity\User;
use App\Event\LikeQuoteEvent;
use App\Event\UnlikeQuoteEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class LikeController extends AbstractController
{
    /**
     * @Route("quote/{id}/like", name="like")
     * @IsGranted("QUOTE_LIKE", subject="quote")
     */
    public function like(Quote $quote, EventDispatcherInterface $eventDispatcher): Response
    {
        /** @var User $user * */
        $user = $this->getUser();

        $userManager = $this->getDoctrine()->getManager();

        $user->addQuoteLike($quote);

        $userManager->flush();

        $event = new LikeQuoteEvent($quote, $user);
        $eventDispatcher->dispatch($event);

        return $this->redirectToRoute('quote_index', [], 301);
    }

    /**
     * @Route("quote/{id}/unlike", name="unlike")
     * @IsGranted("QUOTE_LIKE", subject="quote")
     */
    public function unlike(Quote $quote, EventDispatcherInterface $eventDispatcher): Response
    {
        /** @var User $user * */
        $user = $this->getUser();

        $userManager = $this->getDoctrine()->getManager();

        $user->removeQuoteLike($quote);

        $userManager->flush();

        $event = new UnlikeQuoteEvent($quote, $user);
        $eventDispatcher->dispatch($event);

        return $this->redirectToRoute('quote_index', [], 301);
    }
}
