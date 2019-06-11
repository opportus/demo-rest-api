<?php

namespace App\EventListener;

use Opportus\ExtendedFrameworkBundle\Generator\Context\ControllerException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * The entity validator subscriber.
 *
 * @package App\EventSubscriber
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
class AccessDeniedExceptionHandlerListener
{
    /**
     * Converts `AccessDeniedException` into `ControllerException`.
     *
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!$exception instanceof AccessDeniedHttpException) {
            return;
        }

        $event->setException(new ControllerException(Response::HTTP_FORBIDDEN, null, $exception->getMessage(), 0, $exception));
    }
}
