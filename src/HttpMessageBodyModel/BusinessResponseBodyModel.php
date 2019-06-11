<?php

namespace App\HttpMessageBodyModel;

use DateTimeInterface;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;

/**
 * The business response body model.
 *
 * @package App\HttpMessageBodyModel
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 *
 * @Hateoas\Relation(
 *     "self",
 *     href=@Hateoas\Route("get_business", parameters={"id"="expr(object.id)"})
 * )
 *
 * @Hateoas\Relation(
 *     "users",
 *     embedded = "expr(object.users)"
 * )
 */
final class BusinessResponseBodyModel
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
     * @var string $name
     */
    public $name;

    /**
     * @var BusinessUserResponseBodyModel $users
     *
     * @Serializer\Exclude()
     */
    public $users;
}
