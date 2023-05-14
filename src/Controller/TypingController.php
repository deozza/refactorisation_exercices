<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypingController extends AbstractController
{
    #[Route('/typing', name: 'app_typing')]
    public function index(): Response
    {
        return $this->render('typing/index.html.twig', [
            'controller_name' => 'TypingController',
        ]);
    }
}
