<?php

namespace App\EventSubscriber;

use App\Exception\ApiProblemException;
use App\Response\MailJsonResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @var MailJsonResponse
     */
    protected $response;
    
    public function __construct(MailJsonResponse $response)
    {
        $this->response = $response;
    }
    
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [
                ['processException', 10],
            ],
        ];
    }
    
    
    public function processException(ExceptionEvent $event)
    {
        $exception = $event->getException();
    
        if ($exception instanceof ApiProblemException) {
            $event->setResponse($this->response->fail($exception->getErrors()));
        }
    }
    
}