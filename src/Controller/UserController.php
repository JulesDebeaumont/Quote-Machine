<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        $repositoryQuote = $this->getDoctrine()->getRepository(Quote::class);

        $quotes = $repositoryQuote->createQueryBuilder('q')
            ->select('q')
            ->leftJoin('q.author', 'a')
            ->where('a.id = :author')
            ->setParameter('author', $user->getId())
            ->orderBy('q.creationDate', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'quotes' => $quotes,
        ]);
    }
}
