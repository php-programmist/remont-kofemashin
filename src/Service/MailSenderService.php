<?php

namespace App\Service;

use Swift_Mailer;
use Twig\Environment;

class MailSenderService
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;
    /**
     * @var Environment
     */
    protected $twig;
    
    public function __construct(Swift_Mailer $mailer, Environment $twig)
    {
        
        $this->mailer = $mailer;
        $this->twig   = $twig;
    }
    
    /**
     * @param array|string $to
     * @param string       $subject
     * @param string       $template
     * @param array        $data
     * @param mixed? $from
     *
     * @return int
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function sendMail($to, string $subject, string $template, array $data, $from=null)
    {
        
        $message = (new \Swift_Message($subject))
            ->setTo($to)
            ->setBody(
                $this->twig->render(
                    $template,
                    $data
                ),
                'text/html'
            );
        if ( ! empty($from)) {
            $message->setFrom($from);
        }
        return $this->mailer->send($message);
    }
}