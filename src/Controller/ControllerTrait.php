<?php

namespace App\Controller;

use Opportus\ExtendedFrameworkBundle\EntityGateway\EntityGatewayInterface;

/**
 * The controller trait.
 *
 * @package App\Controller
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
trait ControllerTrait
{
    /**
     * @var EntityGatewayInterface $entityGateway
     */
    private $entityGateway;

    /**
     * Constructs the entity controller
     *
     * @param EntityGatewayInterface $entityGateway
     */
    public function __construct(EntityGatewayInterface $entityGateway)
    {
        $this->entityGateway = $entityGateway;
    }
}
