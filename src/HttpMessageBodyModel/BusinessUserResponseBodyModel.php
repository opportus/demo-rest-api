<?php

namespace App\HttpMessageBodyModel;

use DateTimeInterface;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;

/**
 * The business user response body model.
 *
 * @package App\HttpMessageBodyModel
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 *
 * @Hateoas\Relation(
 *     "self",
 *     href=@Hateoas\Route("get_business_user", parameters={"business_id"="expr(object.business.getId())", "user_id"="expr(object.id)"})
 * )
 */
final class BusinessUserResponseBodyModel
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
     * @var Business $business
     *
     * @Serializer\Exclude()
     */
    public $business;
}
