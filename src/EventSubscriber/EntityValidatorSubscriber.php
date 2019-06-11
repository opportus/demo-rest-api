<?php

namespace App\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * The entity validator subscriber.
 *
 * @package App\EventSubscriber
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
class EntityValidatorSubscriber implements EventSubscriber
{
    /**
     * @var ValidatorInterface $validator
     */
    private $validator;

    /**
     * Constructs the entity validator subscriber.
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preUpdate',
            'preDelete'
        );
    }

    /**
     * Validates entity before CREATE operation.
     *
     * @param  LifecycleEventArgs $args
     * @throws ValidatorException
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $constraintViolationList = $this->validator->validate($args->getEntity());

        if ($constraintViolationList->count() > 0) {
            throw new ValidatorException(
                (string)$constraintViolationList
            );
        }
    }

    /**
     * Validates entity before UPDATE operation.
     *
     * @param  Doctrine\Common\Persistence\Event\LifecycleEventArgs $args
     * @throws Symfony\Component\Validator\Exception\ValidatorException
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $constraintViolationList = $this->validator->validate($args->getEntity());

        if ($constraintViolationList->count() > 0) {
            throw new ValidatorException(
                (string)$constraintViolationList
            );
        }
    }

    /**
     * Validates entity before DELETE operation.
     *
     * @param  Doctrine\Common\Persistence\Event\LifecycleEventArgs $args
     * @throws Symfony\Component\Validator\Exception\ValidatorException
     */
    public function preDelete(LifecycleEventArgs $args)
    {
        $constraintViolationList = $this->validator->validate($args->getEntity());

        if ($constraintViolationList->count() > 0) {
            throw new ValidatorException(
                (string)$constraintViolationList
            );
        }
    }
}
