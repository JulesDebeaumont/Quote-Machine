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
            ->select('q', 'COUNT(l) AS nbLikes')
            ->leftJoin('q.likes', 'l')
            ->leftJoin('q.author', 'a')
            ->where('a.id = :author')
            ->setParameter('author', $user->getId())
            ->groupBy('q')
            ->orderBy('q.creationDate', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        $likes = $repositoryQuote->createQueryBuilder('q')
            ->select('q')
            ->leftJoin('q.likes', 'l')
            ->where('l = :user')
            ->setParameter('user', $user)
            ->orderBy('q.creationDate', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'quotes' => $quotes,
            'likes' => $likes,
        ]);
    }
}
