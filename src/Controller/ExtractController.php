<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExtractController extends AbstractController
{
    #[Route('/extract', name: 'app_extract')]
    public function index(): Response
    {
        return $this->render('extract/index.html.twig', [
            'controller_name' => 'ExtractController',
        ]);
    }
}
