<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DuplicataController extends AbstractController
{
    #[Route('/duplicata', name: 'app_duplicata')]
    public function index(): Response
    {
        return $this->render('duplicata/index.html.twig', [
            'controller_name' => 'DuplicataController',
        ]);
    }
}
