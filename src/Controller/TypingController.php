<?php

namespace App\Controller;

use App\Service\CarService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypingController extends AbstractController
{
    #[Route('/exercices/typing/1', name: 'exercices_typing_1', methods: ['GET'])]
    public function getSum(): Response
    {
        $a = 1.6;
        $b = 2.2;

        $result = $this->sum($a, $b);

        return new Response('The result is 3.8 : ' . $result==3.8);
    }

    private function sum($a,  $b): int
    {
        return $a + $b;
    }

    #[Route('/exercices/typing/2', name: 'exercices_typing_2', methods: ['POST'])]
    public function sellCar(CarService $carService): Response
    {

        $car = new Car();

        $car->brand = 'Renault';
        $car->model = 'Clio';
        $car->isManual = true;
        $car->engine = 'petrol';
        $car->doorNulber = 5;
        $car->category = 'city';
        $car->dateOfBuild = new \DateTime('1992-01-01');
        $car->dateSold = new \DateTime();
        $car->price = 10000;
        $car->buyerName = 'John Doe';
        $car->buyerAddress = '1 rue de la Paix, 75000 Paris';
        $car->buyerPhone = '0600000000';
        $car->buyerEmail = 'johndoe@gmail.com';

        $message = $carService->sellCar($car);

        return new JsonResponse($message, 201);
    }
}
