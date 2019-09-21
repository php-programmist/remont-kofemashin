<?php

namespace App\Controller;

use App\Request\CallbackFormRequest;
use App\Response\MailJsonResponse;
use App\Service\MailSenderService;
use App\Service\RecipientResolverService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Error\Error;

class MailController extends AbstractController
{
    
    /**
     * @var MailJsonResponse
     */
    protected $response;
    
    /**
     * @var MailSenderService
     */
    protected $mail_sender;
    private $email_addresses;
    
    public function __construct(
        MailJsonResponse $response,
        MailSenderService $mail_sender,
        ParameterBagInterface $params
    ) {
        $this->response           = $response;
        $this->mail_sender        = $mail_sender;
        $this->email_addresses = $params->get('email_addresses');
    }
    /**
     * @Route("/mail/callback/", name="mail_callback")
     */
    public function callback(CallbackFormRequest $request)
    {
        $template   = 'emails/callback.html.twig';
        $recipients = $this->email_addresses;
        try{
            $this->mail_sender->sendMail(
                $recipients,
                $request->getSubject(),
                $template,
                $request->toArray()
            );
        } catch (Error $e){
            return $this->response->fail([$e->getMessage()]);
        }
    
        return $this->response->success("Спасибо, отправлено");
    }
    
}