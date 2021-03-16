<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Form\QuoteAddFormType;
use App\Form\QuoteModifyFormType;
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
        /*
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
        */


        $repositoryQuote = $this->getDoctrine()->getRepository(Quote::class);
        $quotes = $repositoryQuote->findAll();

        //dump($quotes);


        $research = $request->query->get('research');
        //dump($research);

        if ($research)
        {
            $filteredQuotes = [];

            foreach ($quotes as $quote)
            {
                mb_stripos($quote->getContent(), $research) ? array_push($filteredQuotes, $quote) : null;
            }
            $quotes = $filteredQuotes;
        }

        return $this->render('quote/index.html.twig', ['quotes' => $quotes]);
    }





    /**
     * @param Quote $quote
     * @param Request $request
     * @return Response
     * @Route("/quotes/modifier/{id}", name="quote_modifier")
     */
    public function modifier(Quote $quote, Request $request) : Response
    {
        $quoteManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(QuoteModifyFormType::class, $quote);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid())
        {

            $quote = $form->getData();
            $quoteManager->flush();

            return $this->redirectToRoute('quote_index', [], 301);
        }

        return $this->render('quote/modifier.html.twig', ['quote' => $quote, 'form' => $form->createView()]);
    }





    /**
     * @param Request $request
     * @return Response
     * @Route("/quotes/ajouter", name="quote_ajouter")
     */
    public function ajouter(Request $request): Response
    {
        $quoteManager = $this->getDoctrine()->getManager();

        $quote = new Quote();
        $form = $this->createForm(QuoteModifyFormType::class, $quote);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $quote = $form->getData();

            $quoteManager->persist($quote);
            $quoteManager->flush();

            return $this->redirectToRoute('quote_index', [], 301);
        }

        return $this->render('quote/ajouter.html.twig', ['form' => $form->createView()]);
    }






    /**
     * @param Quote $quote
     * @return Response
     * @Route("/quotes/supprimer/{id}", name="quote_supprimer")
     */
    public function supprimer(Quote $quote): Response
    {
        $quoteManager= $this->getDoctrine()->getManager();

        $quoteManager->remove($quote);
        $quoteManager->flush();

        return $this->redirectToRoute('quote_index', [], 301);
    }

}
