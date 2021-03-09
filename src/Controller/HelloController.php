<?php
// src/Controller/BlogController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    /**
     * @Route("/hello/{valeur}", name="hello_world")
     * @param $valeur
     * @return Response
     */
    public function index($valeur): Response
    {
        return $this->render('hello/index.html.twig', ['valeur' => $valeur]);
    }
}
