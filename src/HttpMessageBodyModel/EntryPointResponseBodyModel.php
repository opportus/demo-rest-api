<?php

namespace App\HttpMessageBodyModel;

use Hateoas\Configuration\Annotation as Hateoas;

/**
 * The entry point response body model.
 *
 * @package App\HttpMessageBodyModel
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 *
 * @Hateoas\Relation(
 *     "self",
 *     href=@Hateoas\Route("get_entry_point")
 * )
 * 
 * @Hateoas\Relation(
 *     "products",
 *     href=@Hateoas\Route("cget_product")
 * )
 * 
 * @Hateoas\Relation(
 *     "users",
 *     href=@Hateoas\Route("cget_user")
 * )
 * 
 * @Hateoas\Relation(
 *     "businesses",
 *     href=@Hateoas\Route("cget_business")
 * )
 */
final class EntryPointResponseBodyModel
{
}
