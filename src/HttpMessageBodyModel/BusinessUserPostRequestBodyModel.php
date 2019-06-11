<?php

namespace App\HttpMessageBodyModel;

use App\Entity\User;
use Opportus\ExtendedFrameworkBundle\Validator\Constraints as EFAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The business user POST request body model.
 *
 * @package App\HttpMessageBodyModel
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
final class BusinessUserPostRequestBodyModel
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
     */
    public $business = '';
}
