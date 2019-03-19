<?php

namespace DivineOmega\PasswordExposed\Symfony\Validator\Constraints;

use DivineOmega\PasswordExposed\Interfaces\PasswordExposedCheckerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Contracts\Translation\TranslatorInterface;

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

    /** @var TranslatorInterface */
    protected $translator;

    /**
     * @param PasswordExposedCheckerInterface $passwordExposedChecker
     * @param TranslatorInterface             $translator
     */
    public function __construct(PasswordExposedCheckerInterface $passwordExposedChecker, TranslatorInterface $translator)
    {
        $this->passwordExposedChecker = $passwordExposedChecker;
        $this->translator = $translator;
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

        if ($this->passwordExposedChecker->isExposed($value)) {
            $message = $this->translator->trans($constraint->message, [], 'password_exposed');

            $this->context->buildViolation($message)->addViolation();
        }
    }
}
