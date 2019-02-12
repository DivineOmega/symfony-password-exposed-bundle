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
    public $message = 'password_breached';
}
