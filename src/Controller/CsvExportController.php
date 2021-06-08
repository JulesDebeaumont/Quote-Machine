<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CsvExportController extends AbstractController
{
    /**
     * @Route("/csv/export", name="csv_export")
     */
    public function index()
    {
    }
}
