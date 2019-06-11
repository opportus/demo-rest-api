<?php

namespace App\HttpMessageBodyModel;

use App\Entity\Business;
use App\Entity\User;
use Opportus\ExtendedFrameworkBundle\Validator\Constraints as EFAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The user POST request body model.
 *
 * @package App\HttpMessageBodyModel
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
final class UserPostRequestBodyModel
{
    /**
     * @var string $username
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     * @Assert\Email()
     * @EFAssert\ExclusiveEntity(entityFqcn=User::class, key="username")
     */
    public $username;

    /**
     * @var string $business
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @EFAssert\InclusiveEntity(entityFqcn=Business::class, key="id")
     */
    public $business;
}
