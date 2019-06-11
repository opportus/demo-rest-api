<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * The GTIN constraint.
 *
 * @Annotation
 *
 * @package App\Validator\Constraints
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
class Gtin extends Constraint
{
    public $message = 'The value "{{ value }}" is not a valid GTIN-{{ type }}.';
    public $type;

    /**
     * {@inheritdoc}
     */
    public function getRequiredOptions()
    {
        return ['type'];
    }
}
