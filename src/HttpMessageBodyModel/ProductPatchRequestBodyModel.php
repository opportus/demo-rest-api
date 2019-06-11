<?php

namespace App\HttpMessageBodyModel;

use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The product PATCH request body model.
 *
 * @package App\HttpMessageBodyModel
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
final class ProductPatchRequestBodyModel
{
    /**
     * @var null|float $price
     *
     * @AppAssert\Price()
     */
    public $price;

    /**
     * @var null|string $priceCurrency
     *
     * @Assert\Type("string")
     * @Assert\Currency()
     */
    public $priceCurrency;
}
