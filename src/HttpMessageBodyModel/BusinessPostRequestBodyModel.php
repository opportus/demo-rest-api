<?php

namespace App\HttpMessageBodyModel;

use App\Entity\Business;
use Opportus\ExtendedFrameworkBundle\Validator\Constraints as EFAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The business POST request body model.
 *
 * @package App\HttpMessageBodyModel
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
final class BusinessPostRequestBodyModel
{
    /**
     * @var string $name
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     * @EFAssert\ExclusiveEntity(entityFqcn=Business::class, key="name")
     */
    public $name;
}
