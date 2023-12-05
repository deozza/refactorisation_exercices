<?php

namespace App\Controller;

use App\DTO\BuyerInfosDTO;
use App\DTO\SellingInfosDTO;
use App\Entity\Car;
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
        $leftOperator = 1.6;
        $rightOperator = 2.2;

        $result = $this->sum($leftOperator, $rightOperator);

        return new Response('The result is 3.8 : ' . $result===3.8);
    }

    private function sum(float $leftOperator, float $rightOperator): float
    {
        return $leftOperator + $rightOperator;
    }

    #[Route('/exercices/typing/2', name: 'exercices_typing_2', methods: ['POST'])]
    public function sellCar(CarService $carService): Response
    {
        $car = $this->getCar();
        $sellingInfos = $this->getSellingInfos();
        $buyerInfos = $this->getBuyerInfos();

        $message = $carService->sellCar($car, $sellingInfos, $buyerInfos);

        return new JsonResponse($message, 201);
    }

    private function getCar(): Car{
        $brand = 'Renault';
        $model = 'Clio';
        $isManual = true;
        $engine = 'petrol';
        $doorNumber = 5;
        $category = 'city';

        $car = new Car();
        $car->setBrand($brand);
        $car->setModel($model);

        if($isManual == true){
            $car->setGearbox('manual');
        }else{
            $car->setGearbox('automatic');
        }

        $car->setEngine($engine);
        $car->setDoorNumber($doorNumber);
        $car->setCategory($category);

        return $car;
    }

    private function getSellingInfos(): SellingInfosDTO{
        $dateOfBuild = new \DateTime('1992-01-01');
        $dateSold = new \DateTime();
        $price = 10000;

        $sellingInfos = new SellingInfosDTO();
        $sellingInfos->setDateOfBuild($dateOfBuild);
        $sellingInfos->setDateSold($dateSold);
        $sellingInfos->setPrice($price);

        return $sellingInfos;
    }

    private function getBuyerInfos(): BuyerInfosDTO{
        $buyerName = 'John Doe';
        $buyerAddress = '1 rue de la Paix, 75000 Paris';
        $buyerPhone = '0600000000';
        $buyerEmail = 'johndoe@gmail.com';

        $buyerInfos = new BuyerInfosDTO();

        $buyerInfos->setBuyerName($buyerName);
        $buyerInfos->setBuyerAddress($buyerAddress);
        $buyerInfos->setBuyerPhone($buyerPhone);
        $buyerInfos->setBuyerEmail($buyerEmail);

        return $buyerInfos;
    }
}
