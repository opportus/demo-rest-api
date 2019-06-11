<?php

namespace App\HttpMessageBodyModel;

use DateTimeInterface;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;

/**
 * The user response body model.
 *
 * @package App\HttpMessageBodyModel
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 *
 * @Hateoas\Relation(
 *     "self",
 *     href=@Hateoas\Route("get_user", parameters={"id"="expr(object.id)"})
 * )
 *
 * @Hateoas\Relation(
 *     "business",
 *     href=@Hateoas\Route("get_business", parameters={"id"="expr(object.business.id)"}),
 *     embedded = "expr(object.business)"
 * )
 */
final class UserResponseBodyModel
{
    /**
     * @var string $id
     */
    public $id;

    /**
     * @var DateTimeInterface $createdAt
     */
    public $createdAt;

    /**
     * @var string $username
     */
    public $username;

    /**
     * @var BusinessResponseBodyModel $business
     *
     * @Serializer\Exclude()
     */
    public $business;
}
