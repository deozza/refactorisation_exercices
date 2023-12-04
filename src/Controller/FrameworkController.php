<?php

namespace App\Controller;

use App\DTO\LoginDTO;
use App\Form\LoginType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrameworkController extends AbstractController
{
    #[Route('/exercices/framework/1', name: 'exerices_framework_1', methods: ['POST'])]
    public function welcomeUser(Request $request, EntityManagerInterface $em): JsonResponse
    {
            
        $loginDTO = new LoginDTO();
        $form = $this->createForm(LoginType::class, $loginDTO);

        $userInput = json_decode($request->getContent(), true);
        $form->submit($userInput);

        if($form->isValid() === false){
            $response = new Response();
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent(json_encode([
                'error' => 'Invalid form'
            ]));

            return $response;
        }

        $user = $em->getRepository(User::class)->findOneBy([
            'login' => $loginDTO->getLogin(),
            'password' => $loginDTO->getPassword()
        ]);

        if(empty($user) === true){
            $response = new Response();
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent(json_encode([
                'error' => 'Invalid credentials'
            ]));

            return $response;
        }

        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->setContent(json_encode([
            'token' => 'yoursecrettoken'
        ]));

        return $response;

    }

    #[Route('/exercices/framework/2', name: 'exerices_framework_2', methods: ['GET'])]
    public function getCarWithFilters(Request $request, CarRepository $carRepository): JsonResponse
    {
        $filters = $request->query->all('filters');
        $cars = $carRepository->findByFilters($filters);

        return new JsonResponse($cars);
    }
}
