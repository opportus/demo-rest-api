<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * The price constraint.
 *
 * @Annotation
 *
 * @package App\Validator\Constraints
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
class Price extends Constraint
{
    public $message = 'The value "{{ value }}" is not a valid price.';
}
