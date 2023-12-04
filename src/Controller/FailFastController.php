<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Service\UserService;

class FailFastController extends AbstractController
{
    #[Route('/exercices/failfast/1', name: 'exercices_failfast_1', methods: ['GET'])]
    public function getProfile(Request $request, UserService $userService): Response
    {
        $userToken = $request->headers->get('Authorization');
        $expectedTokenNeedle = 'superxtrasecrettoken';
        $unauthorizedResponse = new Response('Unauthorized', Response::HTTP_UNAUTHORIZED);

        if($userToken === null){
            return $unauthorizedResponse;
        }

        if(strpos($userToken, $expectedTokenNeedle) === false){
            return $unauthorizedResponse;
        }

        $user = $userService->getUserByToken($userToken);
        if($user === null){
            return $unauthorizedResponse;
        }

        return new Response('Hello '.$user, Response::HTTP_OK);
    }

    #[Route('/exercices/failfast/2/{brand}/{model}', name: 'exercices_failfast_2', methods: ['PATCH'])]
    public function updateCar(Request $request, EntityManagerInterface $em, string $brand, string $model): Response
    {   
        $userToken = $request->headers->get('Authorization');
        $expectedToken = 'iamthecaptainnow';

        if($userToken === null){
            return new Response('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        if($userToken !== $expectedToken){
            return new Response('Forbidden', Response::HTTP_FORBIDDEN);
        }

        $car = $em->getRepository(Car::class)->findOneBy([
            'brand' => $brand,
            'model' => $model
        ]);

        if($car === null) {
            return new Response('Car not found', Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(UpdateCarType::class, $car);

        $form->submit($data);

        if($form->isValid() === false){
            return new Response('Invalid data', Response::HTTP_BAD_REQUEST);
        }

        $enginesNotCompatibleWithManual = [
            'electric',
            'hybrid'
        ];

        if($car->getGeabox() === 'manual' && in_array($car->getEngine(), $enginesNotCompatibleWithManual) === false){
            return new Response('Invalid data', Response::HTTP_BAD_REQUEST);
        }

        $em->flush();

        return new Response('Car updated', Response::HTTP_OK);
        
    }
}
