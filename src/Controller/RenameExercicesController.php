<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RenameExercicesController extends AbstractController
{
    const MINIMUM_AGE_REQUIRED = 21;

    #[Route('/exercices/rename/1', name: 'exercices_rename_1', methods: ['POST'])]
    public function checkIfAuthorized(Request $request): JsonResponse
    {
        $userInputs = json_decode($request->getContent(), $assoc = true);
        $userAge = $userInputs['a'];

        if($userAge >= self::MINIMUM_AGE_REQUIRED){
            return new JsonResponse(['result' => true], JsonResponse::HTTP_OK);
        }

        return new JsonResponse(['result' => false], JsonResponse::HTTP_FORBIDDEN);
    }
}
