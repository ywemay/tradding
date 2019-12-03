<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Product;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class ProductSubscriber implements EventSubscriberInterface
{

    private $security;

    public function __construct(Security $security) {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['createUser', EventPriorities::POST_WRITE],
        ];
    }

    public function createUser(ViewEvent $event)
    {
        $product = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$product instanceof Product || Request::METHOD_POST !== $method) {
            return;
        }

        $user = $this->security->getUser();
        $product->setOwner($user);
    }

}
