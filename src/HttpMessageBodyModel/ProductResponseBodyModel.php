<?php

namespace App\HttpMessageBodyModel;

use DateTimeInterface;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * The product response body model.
 *
 * @package App\HttpMessageBodyModel
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 *
 * @Hateoas\Relation("self", href=@Hateoas\Route("get_product", parameters={"id"="expr(object.id)"}))
 */
final class ProductResponseBodyModel
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
     * @var string $gtin14
     */
    public $gtin14;

    /**
     * @var float $price
     */
    public $price;

    /**
     * @var string $priceCurrency
     */
    public $priceCurrency;
}
