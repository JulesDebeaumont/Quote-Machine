<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Form\QuoteModifyFormType;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends AbstractController
{
    /**
     * @Route("/quotes", name="quote_index")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $repositoryQuote = $this->getDoctrine()->getRepository(Quote::class);

        $research = $request->query->get('research');
        $research = "%{$research}%";

        $query = $repositoryQuote->createQueryBuilder('q')
              ->where('q.content LIKE :research')
              ->setParameter('research', $research)
              ->orderBy('q.meta', 'ASC')
              ->getQuery();

        //$quotes = $query->getResult();
        //useless 'cause of paginator

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('quote/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/quotes/{id}/modifier", name="quote_modifier")
     * @IsGranted("QUOTE_EDIT", subject="quote")
     */
    public function modifier(Quote $quote, Request $request): Response
    {
        $quoteManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(QuoteModifyFormType::class, $quote);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quote = $form->getData();
            $quoteManager->flush();

            return $this->redirectToRoute('quote_index', [], 301);
        }

        return $this->render('quote/modifier.html.twig', ['quote' => $quote, 'form' => $form->createView()]);
    }

    /**
     * @Route("/quotes/ajouter", name="quote_ajouter")
     */
    public function ajouter(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $quoteManager = $this->getDoctrine()->getManager();

        $quote = new Quote();
        $form = $this->createForm(QuoteModifyFormType::class, $quote);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quote = $form->getData();

            $quoteManager->persist($quote);
            $quoteManager->flush();

            return $this->redirectToRoute('quote_index', [], 301);
        }

        return $this->render('quote/ajouter.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/quotes/{id}/supprimer", name="quote_supprimer")
     * @IsGranted("QUOTE_EDIT", subject="quote")
     */
    public function supprimer(Quote $quote): Response
    {
        $quoteManager = $this->getDoctrine()->getManager();

        $quoteManager->remove($quote);
        $quoteManager->flush();

        return $this->redirectToRoute('quote_index', [], 301);
    }

    /**
     * @Route ("/quotes/random", name="quote_random")
     */
    public function random(): Response
    {
        $repositoryQuote = $this->getDoctrine()->getRepository(Quote::class);

        $query = $repositoryQuote->createQueryBuilder('q')
            ->orderBy('RAND()')
            ->setMaxResults(1)
            ->getQuery();

        $quote = $query->getResult();

        return $this->render('quote/random.html.twig', ['quote' => $quote]);
    }
}
