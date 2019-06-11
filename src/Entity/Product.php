<?php

namespace App\Entity;

use App\Validator\Constraints as AppAssert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The product.
 *
 * @package App\Entity
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 *
 * @ORM\Entity()
 * @ORM\Table(name="product")
 */
class Product extends AbstractEntity
{
    /**
     * @var string $gtin14
     *
     * @ORM\Column(name="gtin_14", type="string", length=14, unique=true)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @AppAssert\Gtin(type=14)
     */
    private $gtin14;

    /**
     * @var float $price
     *
     * @ORM\Column(name="price", type="decimal", precision=7, scale=2)
     * @Assert\NotNull()
     * @AppAssert\Price()
     */
    private $price;

    /**
     * @var string $priceCurrency
     *
     * @ORM\Column(name="price_currency", type="string", length=3)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Currency()
     */
    private $priceCurrency;

    /**
     * Constructs the product.
     *
     * @param string $gtin14
     * @param float $price
     * @param string $priceCurrency
     */
    public function __construct(string $gtin14, float $price, string $priceCurrency)
    {
        parent::__construct();

        $this->gtin14        = $gtin14;
        $this->price         = $price;
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * Gets the GTIN-14.
     *
     * @return string
     */
    public function getGtin14(): string
    {
        return $this->gtin14;
    }

    /**
     * Gets the price.
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Sets the price.
     *
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * Gets the price currency.
     *
     * @return string
     */
    public function getPriceCurrency(): string
    {
        return $this->priceCurrency;
    }

    /**
     * Sets the price currency.
     *
     * @param string $priceCurrency
     */
    public function setPriceCurrency(string $priceCurrency)
    {
        $this->priceCurrency = $priceCurrency;
    }
}
