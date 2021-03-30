<?php

namespace App\Controller;

use App\Entity\Quote;
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


        $repositoryQuote = $this->getDoctrine()->getRepository(Quote::class);

        $research = $request->query->get('research');
        $research = "%{$research}%";

        $query = $repositoryQuote->createQueryBuilder('q')
              ->where('q.content LIKE :research')
              ->setParameter('research', $research)
              ->orderBy('q.meta', 'ASC')
              ->getQuery();

        $quotes = $query->getResult();

        //dump($quotes);
        //dump($research);

        return $this->render('quote/index.html.twig', ['quotes' => $quotes]);
    }





    /**
     * @param Quote $quote
     * @param Request $request
     * @return Response
     * @Route("/quotes/{id}/modifier", name="quote_modifier")
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
     * @Route("/quotes/{id}/supprimer", name="quote_supprimer")
     */
    public function supprimer(Quote $quote): Response
    {
        $quoteManager= $this->getDoctrine()->getManager();

        $quoteManager->remove($quote);
        $quoteManager->flush();

        return $this->redirectToRoute('quote_index', [], 301);
    }

}