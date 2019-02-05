<?php

namespace DivineOmega\PasswordExposed\Symfony\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class PasswordExposed
 *
 * @package DivineOmega\PasswordExposed\Symfony\Validator\Constraints
 * @author  Nikita Loges
 */
class PasswordExposed extends Constraint
{

    /** @var string */
    public $message = 'Password has been exposed in a data breach. You can\'t use this one.';
}
