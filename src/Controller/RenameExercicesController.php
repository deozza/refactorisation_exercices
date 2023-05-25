<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RenameExercicesController extends AbstractController
{
    const AGE_MINIMUM = 21;

    #[Route('/exercices/rename/1', name: 'exercices_rename_1', methods: ['POST'])]
    public function userHasCorrectAge(Request $request): JsonResponse
    {
        $age = json_decode($request->getContent(), true)['a'];
        
        if($age >= self::AGE_MINIMUM){
            return new JsonResponse(['result' => true], 200);
        }

        return new JsonResponse(['result' => false], 403);
    }
}
