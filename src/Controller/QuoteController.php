<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends AbstractController
{
    /**
     * @Route("/quotes", name="quote_index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {

        $quotes = [
            [
                'content' => ' Sire, Sire ! On en a gros !',
                'meta' => 'Perceval, Livre II, Les Exploités'
            ],[
                'content' => ' Tout le monde est une pute, Grace. Nous vendons juste différentes parties de nous-mêmes.',
                'meta' => 'Tommy Shelby'
            ],[
                'content' => ' Je viens de lui mettre une balle dans la tête…… Il m’a regardé de travers.',
                'meta' => 'Tommy Shelby'
            ],[
                'content' => " 2500 pièces d'or ???! Eh... eh... c'est un blague? 2500 pièces d'or, mais ou voulez vous que j'trouve 2500 pièces d'or, dans l'cul d'une vache ?!",
                'meta' => 'Seigneur Jacca, Livre I, 21 : La taxe militaire'
            ],[
                'content' => " J’ai pénétré leur lieu d'habitation de façon subrogative […] en tapinant.",
                'meta' => 'Hervé de Rinel, Livre III, 91 : L’Espion'
            ]

        ];


        $research = $request->query->get('research');
        //dump($research);

        if ($research)
        {
            $filteredQuotes = [];

            foreach ($quotes as $quote)
            {
                stripos($quote['content'], $research) ? array_push($filteredQuotes, $quote) : null;
            }
            $quotes = $filteredQuotes;
        }

        return $this->render('quote/index.html.twig', ['quotes' => $quotes]);
    }
}
