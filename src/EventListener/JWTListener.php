<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;

final class JWTListener
{
    /**
     * @param JWTExpiredEvent $event
     */
    public function onJWTExpired(JWTExpiredEvent $event)
    {
        /** @var JWTAuthenticationFailureResponse */
        $response = $event->getResponse();

        //dd(get_class_methods($response));
        $response->setData(['customCode' => 50014]);
        // $response->setMessage('Your token is expired, please renew it.');
    }
}
