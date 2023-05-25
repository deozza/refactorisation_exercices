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

        $isMessageAnEmail = $this->checkIfMessageIsAnEmail($data['messageType']);

        $message = $this->initMessage($template, $data);


        if($isMessageAnEmail){
        
            $message['subject'] = $data['subject'];

            $provider = $this->getProvider($template, $data);

            $toForEmailAccordingToProvider = $this->getForEmailToAccordingToProvider($provider, $message['to'], $data['env']);

            $message['to'] = $toForEmailAccordingToProvider;

            $message['body'] = $this->getMessageAccordingToAttachment($data, $message['body']);

            return new JsonResponse([
                'message' => $message
            ], 201);
        }

        if($isMessageAnEmail === false){
            return new JsonResponse([
                'message' => $message
            ], 201);
        }
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

    private function checkIfMessageIsAnEmail($messageType) {

        if($messageType === 'email'){
            return true;
        }

        return false;

    }

    private function initMessage($template, $data) {
        $body = sprintf($template, $data['to'], $data['from'], $data['body']);

        $message = [
            'to' => $data['to'],
            'from' => $data['from'],
            'body' => $body
        ];

        return $message;
    }

    private function getProvider($template, $data) {
        $provider = 'textMailSender';

        if(strpos($template, '<html>') !== false && strpos($template, '</html>') !== false){
            $provider = 'htmlMailSender';
        }

        if(isset($data, 'forcesProvider')){
            $provider = $data['forcesProvider'];
        }

        return $provider;
    }

    private function getForEmailToAccordingToProvider($provider, $to, $env){
        if($env === 'test'){
            $to = 'test@gmail.com';
            return $to;
        }

        if($provider === 'textMailSender'){
            if(is_string($to)){
                $to = explode(',', $to);
            }
        }

        return $to;
    }

    private function getMessageAccordingToAttachment($data, $body) {
        $fileExists = file_exists($data['attachment']);

        if(!$fileExists){
            return new JsonResponse([
                'message' => 'File not found'
            ], 404);
        }

        $attachment = file_get_contents($data['attachment']);

        if($provider === 'textMailSender'){
            $body .= 'Vous trouverez en pièce jointe le fichier';
            $message['attachment'] = $attachment;
            
        }

        if($provider === 'htmlMailSender'){
            $encodedAttachment = base64_encode($attachment);
            $body .= '<p>Vous trouverez en pièce jointe le fichier</p>';
            $message['attachment'] = $encodedAttachment;
        }

        return $body;
    }
}
