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
        $plantLeft = $this->getPlantLeft();
        $plantRight = $this->getPlantRight();

        $incompatibilities = $this->getListOfIncompatibilities($plantLeft, $plantRight);

        if(empty($incompatibilities)) {
            $message = 'The plants are compatible';
            return new JsonResponse($message, JsonResponse::HTTP_OK);
        } 

        $message = $this->buildMessageAccordingToIncompatibilities($incompatibilities);
        return new JsonResponse($message, JsonResponse::HTTP_BAD_REQUEST);
    }

    private function getPlantLeft() {
        return [
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
    }

    private function getPlantRight() {
        return [
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
    }

    private function getListOfIncompatibilities($plantLeft, $plantRight) {
        $incompatibilities = [];

        if (!$this->getSoilCompatibility($plantLeft, $plantRight)) {
            $incompatibilities[] = 'soil';
        }

        if (!$this->getExposureCompatibility($plantLeft, $plantRight)) {
            $incompatibilities[] = 'exposure';
        }

        if (!$this->getFertilizerCompatibility($plantLeft, $plantRight)) {
            $incompatibilities[] = 'fertilizer';
        }

        if (!$this->getWaterCompatibility($plantLeft, $plantRight)) {
            $incompatibilities[] = 'water';
        }

        if (!$this->getSoilPhCompatibility($plantLeft, $plantRight)) {
            $incompatibilities[] = 'soil ph';
        }

        if (!$this->getSoilMoistureCompatibility($plantLeft, $plantRight)) {
            $incompatibilities[] = 'soil moisture';
        }

        return $incompatibilities;
    }

    private function getSoilCompatibility($plantLeft, $plantRight) {
        return $plantLeft['soil'] === $plantRight['soil'];
    }

    private function getExposureCompatibility($plantLeft, $plantRight) {
        return $plantLeft['exposure'] === $plantRight['exposure'];
    }

    private function getFertilizerCompatibility($plantLeft, $plantRight) {
        return $plantLeft['fertilizer'] === $plantRight['fertilizer'];
    }

    private function getWaterCompatibility($plantLeft, $plantRight) {
        return $plantLeft['water'] === $plantRight['water'];
    }

    private function getSoilPhCompatibility($plantLeft, $plantRight) {
        return $plantLeft['maxSoilPh'] >= $plantRight['minSoilPh'] && $plantLeft['minSoilPh'] <= $plantRight['maxSoilPh'];
    }

    private function getSoilMoistureCompatibility($plantLeft, $plantRight) {
        return $plantLeft['maxSoilMoisture'] >= $plantRight['minSoilMoisture'] && $plantLeft['minSoilMoisture'] <= $plantRight['maxSoilMoisture'];
    }

    private function buildMessageAccordingToIncompatibilities($incompatibilities) {
        $message = '';

        foreach($incompatibilities as $key => $value) {
            if ($key === 0) {
                $message .= 'The plants are not compatible because of ' . $value;
            } else {
                $message .= ', ' . $value;
            }
        }

        return $message;
    }


}
