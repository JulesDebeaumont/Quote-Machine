<?php

namespace App\Controller;

use App\Entity\Quote;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CsvExportController extends AbstractController
{
    /**
     * @Route("/csv/export", name="csv_export")
     */
    public function index(SerializerInterface $serializer): Response
    {
        $repositoryQuote = $this->getDoctrine()->getRepository(Quote::class);

        $response = new Response($serializer->serialize($repositoryQuote->findAll(), 'csv', ['group' => 'quote:readAll']));

        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            'quotes.csv'
        );

        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
