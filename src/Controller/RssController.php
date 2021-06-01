<?php

namespace App\Controller;

use App\Entity\Quote;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RssController extends AbstractController
{
    /**
     * @Route("/rss", name="rss", defaults={"_format"="xml"})
     */
    public function index(): Response
    {
        $repositoryQuote = $this->getDoctrine()->getRepository(Quote::class);

        $allQuotes = $repositoryQuote->createQueryBuilder('q')
            ->orderBy('q.creationDate', 'ASC')
            ->getQuery()
            ->getResult();

        return $this->render('rss/index.xml.twig', [
            'quotes' => $allQuotes,
        ]);
    }
}
