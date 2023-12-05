<?php

namespace App\Service;

use App\DTO\BuyerInfosDTO;
use App\DTO\SellingInfosDTO;
use App\Repository\CarRepository;
use App\Entity\Car;

class CarService{

    private CarRepository $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function sellCar(Car $car, SellingInfosDTO $sellingInfos, BuyerInfosDTO $buyerInfos): string {
        $message = 'This ';

        if($sellingInfos->getDateOfBuild() < '1993-01-01'){
            $message .= 'old ';
        }

        $message .= 'car is a ' . $car->getBrand() . ' ' . $car->getModel() . ' with a ' . $car->getEngine() . ' engine. It has ' . $car->getDoorNumber() . ' doors and a ' . $car->getGearbox() . ' gearbox. It is a ' . $car->getCategory() . ' car.';
        $message .= ' It was built in ' . $sellingInfos->getDateOfBuild()->format('Y') . ' and sold in ' . $sellingInfos->getDateSold()->format('Y') . ' for ' . $sellingInfos->getPrice() . '€. The buyer is ' . $buyerInfos->getBuyerName() . ' who lives at ' . $buyerInfos->getBuyerAddress() . '. You can contact him at ' . $buyerInfos->getBuyerPhone() . ' or ' . $buyerInfos->getBuyerEmail() . '.';
        return $message;
    }
}