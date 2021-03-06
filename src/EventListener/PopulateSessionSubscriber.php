<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\EventListener;

use Setono\TagBagBundle\TagBag\TagBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class PopulateSessionSubscriber implements EventSubscriberInterface
{
    /** @var TagBagInterface */
    private $tagBag;

    /** @var string */
    private $sessionKey;

    public function __construct(TagBagInterface $tagBag, string $sessionKey)
    {
        $this->tagBag = $tagBag;
        $this->sessionKey = $sessionKey;
    }

    public static function getSubscribedEvents(): array
    {
        /*
         * The priority needs to be higher than Symfony\Component\HttpKernel\EventListener\SessionListener
         * which is -1000, but still lower than 0 so that people can listen to the response event without
         * worrying about priorities
         */
        return [
            KernelEvents::RESPONSE => ['onKernelResponse', -100],
        ];
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        /**
         * Before SF5 the session could be null
         *
         * @var SessionInterface|null
         */
        $session = $event->getRequest()->getSession();
        if (null === $session) {
            return;
        }

        if ($this->tagBag->count() > 0) {
            $session->set($this->sessionKey, $this->tagBag->all());
        } else {
            $session->remove($this->sessionKey);
        }
    }
}
