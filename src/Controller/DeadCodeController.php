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
        $dataArray = json_decode($request->getContent(), true);

        // On teste si les données envoyées sont correctes
        if(isset($dataArray['number'])){
            $number = $dataArray['number'];

            if(ctype_digit($number) === false){
                $message = 'La valeur doit être un nombre';
                return new Response($message, 400);
            }

            if($number > 0){
                $factoriel = $this->getFactorielRecursive($number);
                return new Response($factoriel, 200);
            }elseif($number === 0){
                $message = 'Le résultat est 1';
                return new Response(1, 200);
            }else{
                $message = 'Le nombre doit être positif';
                return new Response($message, 400);
            }
        }else{
            $message = 'Il faut envoyer des données';            
            return new Response($message, 400);
        }
    }

    private function getFactorielRecursive(int $number): int
    {
        if($number === 1){
            return 1;
        }else{
            return $number * $this->getFactorielRecursive($number - 1);
        }
    }
}
