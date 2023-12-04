<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeadCodeController extends AbstractController
{
    #[Route('/exercices/deadcode/1', name: 'exercise_deadcode_1', methods: ['POST'])]
    public function getFactoriel(Request $request): Response
    {
        /**
         * @param array $userInput
         */
        $userInput = json_decode($request->getContent(), true);
        $badRequestResponse = new Response('Invalid data', Response::HTTP_BAD_REQUEST);

        if(isset($userInput['number'])){
            $startingNumber = $userInput['number'];

            if(ctype_digit($startingNumber) === false){
                return $badRequestResponse;
            }

            if($startingNumber > 0){
                $factoriel = $this->getFactorielRecursive($startingNumber);
                return new Response($factoriel, Response::HTTP_OK);
            }
            
            return $badRequestResponse;
        }
        
        return $badRequestResponse;
    }

    private function getFactorielRecursive(int $startingNumber): int
    {
        if($startingNumber === 1){
            return 1;
        }

        return $startingNumber * $this->getFactorielRecursive($startingNumber - 1);
    }
}
