<?php

namespace App\HttpMessageBodyModel;

use App\Entity\Product;
use App\Validator\Constraints as AppAssert;
use Opportus\ExtendedFrameworkBundle\Validator\Constraints as EFAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The product POST request body model.
 *
 * @package App\HttpMessageBodyModel
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
final class ProductPostRequestBodyModel
{
    /**
     * @var string $gtin14
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @AppAssert\Gtin(type=14)
     * @EFAssert\ExclusiveEntity(entityFqcn=Product::class, key="gtin14")
     */
    public $gtin14;

    /**
     * @var float $price
     *
     * @Assert\NotNull()
     * @AppAssert\Price()
     */
    public $price;

    /**
     * @var string $priceCurrency
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Currency()
     */
    public $priceCurrency;
}
