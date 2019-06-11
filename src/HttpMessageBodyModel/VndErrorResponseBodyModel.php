<?php

namespace App\HttpMessageBodyModel;

/**
 * The VND error response body model.
 *
 * @package App\HttpMessageBodyModel
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
final class VndErrorResponseBodyModel
{
    /**
     * @var string $message
     */
    public $message;

    /**
     * @var string $path
     */
    public $path;

    /**
     * Constructs the VND error response body model.
     *
     * @param string $propertyPath
     */
    public function __construct(string $propertyPath)
    {
        $this->path = $propertyPath;
    }
}
