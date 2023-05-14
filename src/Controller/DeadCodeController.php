<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeadCodeController extends AbstractController
{
    #[Route('/dead/code', name: 'app_dead_code')]
    public function index(): Response
    {
        return $this->render('dead_code/index.html.twig', [
            'controller_name' => 'DeadCodeController',
        ]);
    }
}
