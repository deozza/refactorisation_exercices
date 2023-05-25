<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExtractController extends AbstractController
{
    #[Route('/exercices/rename/1', name: 'exercices_rename_1', methods: ['GET'])]
    public function checkPlantsAreCompatible(): Response
    {

        $plants = $this->getPlants();
        $isCompatible = $this->getCompatible($plants);

        // on teste si les variables boolean sont vraies
        // on renvoie

        $errorMessage = $this->buildErrorMessageForCompatibility($isCompatible);

        if($errorMessage !== ''){
            $status = 400;
            return new JsonResponse($errorMessage, $status);
        }

        $validMessage = 'The plants are compatible';
        $status = 200;
            
        return new JsonResponse($validMessage, $status);
    }

    public function getPlants(){

        $plantLeft = [
            'name' => 'Tomato',
            'soil' => 'clay',
            'exposure' => 'south',
            'hardiness' => '0',
            'fertilizer' => 'every week',
            'water' => 'every day',
            'maxSoilPh' => '7',
            'minSoilPh' => '6',
            'maxSoilMoisture' => '100',
            'minSoilMoisture' => '80',
        ];

        $plantRight = [
            'name' => 'Rose',
            'soil' => 'clay',
            'exposure' => 'south',
            'hardiness' => '0',
            'fertilizer' => 'every week',
            'water' => 'every week',
            'maxSoilPh' => '7',
            'minSoilPh' => '6',
            'maxSoilMoisture' => '75',
            'minSoilMoisture' => '55',
        ];

        return [
            'plantLeft' => $plantLeft,
            'plantRight' => $plantRight
        ];
    }

    public function getSoilCompatible($plantLeft, $plantRight){
        return $plantLeft['soil'] === $plantRight['soil'];
    }

    public function getCompatible($plants) {
        $isSoilCompatible = $this->getSoilCompatible($plants['plantLeft'], $plants['plantRight']);
        $isExposureCompatible = $this->getSoilCompatible($plants['plantLeft'], $plants['plantRight']);
        $isFertilizerCompatible = $this->getSoilCompatible($plants['plantLeft'], $plants['plantRight']);
        $isWaterCompatible = $this->getSoilCompatible($plants['plantLeft'], $plants['plantRight']);
        $isSoilPhCompatible = $this->getSoilCompatible($plants['plantLeft'], $plants['plantRight']);
        $isSoilMoistureCompatible = $this->getSoilCompatible($plants['plantLeft'], $plants['plantRight']);

        $isCompatible = [
            'isSoilCompatible' => $isSoilCompatible,
            'isExposureCompatible' => $isExposureCompatible,
            'isFertilizerCompatible' => $isFertilizerCompatible,
            'isWaterCompatible' => $isWaterCompatible,
            'isSoilPhCompatible' => $isSoilPhCompatible,
            'isSoilMoistureCompatible' => $isSoilMoistureCompatible,
        ];

        return $isCompatible;
    }

    public function buildErrorMessageForCompatibility($isCompatible) {
        $message = '';

        foreach($isCompatible as $key => $value) {
            
            if (!$value) {

                switch($key) {
                    case 'isSoilCompatible':
                        $reason = 'soil';
                        break;
                    case 'isExposureCompatible':
                        $reason = 'exposure';
                        break;
                    case 'isFertilizerCompatible':
                        $reason = 'fertilizer';
                        break;
                    case 'isWaterCompatible':
                        $reason = 'water';
                        break;
                    case 'isSoilPhCompatible':
                        $reason = 'soil ph';
                        break;
                    case 'isSoilMoistureCompatible':
                        $reason = 'soil moisture';
                        break;
                }

                if(empty($message)) {
                    $message = 'The plants are not compatible because of ' . $reason;
                } else {
                    $message .= ', ' . $key;
                }
            }
        }

        return $message;

    }
}
