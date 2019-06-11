<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Choice as ChoiceConstraint;
use Symfony\Component\Validator\Constraints\Collection as CollectionConstraint;
use Symfony\Component\Validator\Constraints\DateTime as DateTimeConstraint;
use Symfony\Component\Validator\Constraints\NotBlank as NotBlankConstraint;
use Symfony\Component\Validator\Constraints\Optional as OptionalConstraint;
use Symfony\Component\Validator\Constraints\Type as TypeConstraint;
use Symfony\Component\Validator\Constraints\Uuid as UuidConstraint;

/**
 * The user collection query constraint.
 *
 * @package App\Validator\Constraints
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
class UserCollectionQuery extends CollectionConstraint
{
    /**
     * Constructs the user collection query constraint.
     */
    public function __construct()
    {
        parent::__construct($this->defineOptions());
    }

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return CollectionConstraint::class.'Validator';
    }

    /**
     * Defines the options.
     *
     * @return array
     */
    private function defineOptions()
    {
        return [
            'fields'=> [
                'criteria' => new OptionalConstraint([
                    new CollectionConstraint([
                        'fields' => [
                            'id' => new OptionalConstraint([
                                new NotBlankConstraint(),
                                new UuidConstraint(),
                            ]),
                            'createdAt' => new OptionalConstraint([
                                new NotBlankConstraint(),
                                new DateTimeConstraint(),
                            ]),
                            'username' => new OptionalConstraint([
                                new NotBlankConstraint(),
                                new TypeConstraint(['type' => 'string']),
                            ]),
                        ],
                    ]),
                ]),
                'order' => new OptionalConstraint([
                    new CollectionConstraint([
                        'fields' => [
                            'id' => new OptionalConstraint([
                                new NotBlankConstraint(),
                                new ChoiceConstraint([
                                    'choices' => [
                                        'ASC',
                                        'DESC',
                                    ]
                                ]),
                            ]),
                            'createdAt' => new OptionalConstraint([
                                new NotBlankConstraint(),
                                new ChoiceConstraint([
                                    'choices' => [
                                        'ASC',
                                        'DESC',
                                    ]
                                ]),
                            ]),
                            'username' => new OptionalConstraint([
                                new NotBlankConstraint(),
                                new ChoiceConstraint([
                                    'choices' => [
                                        'ASC',
                                        'DESC',
                                    ]
                                ]),
                            ]),
                        ],
                    ]),
                ]),
                'limit' => new OptionalConstraint([
                    new NotBlankConstraint(),
                    new TypeConstraint(['type' => 'digit']),
                ]),
                'offset' => new OptionalConstraint([
                    new NotBlankConstraint(),
                    new TypeConstraint(['type' => 'digit']),
                ]),
            ],
        ];
    }
}
