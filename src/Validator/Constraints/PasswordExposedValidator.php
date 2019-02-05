<?php

namespace DivineOmega\PasswordExposed\Symfony\Validator\Constraints;

use DivineOmega\PasswordExposed\Interfaces\PasswordExposedCheckerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use function is_string;

/**
 * Class PasswordExposedValidator
 *
 * @package DivineOmega\PasswordExposed\Symfony\Validator\Constraints
 * @author  Nikita Loges
 */
class PasswordExposedValidator extends ConstraintValidator
{

    /** @var PasswordExposedCheckerInterface */
    protected $passwordExposedChecker;

    /**
     * @param PasswordExposedCheckerInterface $passwordExposedChecker
     */
    public function __construct(PasswordExposedCheckerInterface $passwordExposedChecker)
    {
        $this->passwordExposedChecker = $passwordExposedChecker;
    }

    /**
     * @inheritdoc
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof PasswordExposed) {
            throw new UnexpectedTypeException($constraint, PasswordExposed::class);
        }

        if ($value === null || $value === '') {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        if ($this->passwordExposedChecker->isExposed($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
