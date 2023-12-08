<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DuplicataController extends AbstractController
{
    #[Route('/exercices/duplicata/1', name: 'exercices_duplicata_1', methods: ['POST'])]
    public function sendMessage(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        
        $template = $this->getTemplateById($data['templateId']);

        if($data['messageType'] === 'sms'){
            $message = $this->createSms($template, $data);
        }

        if($data['messageType'] === 'email'){
            $message = $this->createEmail($template, $data);
        }

        if($message === false) {
            return new JsonResponse([
                'message' => 'File not found'
            ], 404);
        }

        return new JsonResponse([
           'message' => $message
        ], 201);
    }

    private function getTemplateById(int $id): string
    {
        $textTemplate = 'Bonjour %s, vous avez reçu un message de %s : %s';
        $htmlTemplate = '<html><p>Bonjour %s, vous avez reçu un message de %s : %s</p></html>';

        if($id < 10){
            return $textTemplate;
        }

        return $htmlTemplate;
    }

    private function createSms($template, $data) {
        $to = $data['to'];
        $body = $this->createBody($template, $data);
        $from = $data['from'];

        $message = $this->createMessage($to, $body, $from);
        
        return $message;
    }

    private function createEmail($template, $data) {
        $provider = $this->determineProvider($template, $data);        
        $body = $this->createBody($template, $data);

        $message = $this->createMessage($data['to'], $body, $data['from']);
        $message['subject'] = $data['subject'];


        // on vérifie si l'utilisateur veut envoyer un pièce jointe
        if(isset($data['attachment'])){
            $attachment = $this->getAttachment($data);
            if($attachment === false) {
                return false;
            }

            $bodyWithAttachment = 'Vous trouverez en pièce jointe le fichier';

            // on converti en base64 le fichier et ajouter une phrase en html si c'est htmlMailSender
            if($provider === 'htmlMailSender'){
                $$attachment = base64_encode($attachment);
                $bodyWithAttachment = '<p>'. $bodyWithAttachment .'</p>';
            }

            $message['attachment'] = $attachment;
            $body .= $bodyWithAttachment;
            $message['body'] = $body;
        } 

        return $message;
    }

    private function determineProvider($template, $data) {
        $provider = 'textMailSender';

        if(strpos($template, '<html>') !== false && strpos($template, '</html>') !== false){
            $provider = 'htmlMailSender';
        }

        if(isset($data, 'forcesProvider')){
            $provider = $data['forcesProvider'];
        }

        return $provider;
    }

    private function createBody($template, $data) {
        $body = sprintf($template, $data['to'], $data['from'], $data['body']);
        return $body;
    }

    private function createMessage($to, $body, $from) {
        $message = [
            'to' => $to,
            'body' => $body,
            'from' => $from
        ];

        return $message;
    }

    private function getAttachment($data) {
        // on vérifie que la pièce jointe existe
        $fileExists = file_exists($data['attachment']);
        if(!$fileExists){
            return false;
        }

        // on affecte $attachment la valeur de la pièce jointe
        $attachment = file_get_contents($data['attachment']);
        return $attachment;
    }
}
