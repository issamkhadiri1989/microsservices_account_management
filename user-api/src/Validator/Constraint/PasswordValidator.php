<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class PasswordValidator extends ConstraintValidator
{
    private const string PATTERN = '/^(?=.*[a-z])(?=.*[A-Z]).{8,}$/';

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Password) {
            throw new UnexpectedTypeException($constraint, Password::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!\is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (\preg_match(subject: $value,  pattern: self::PATTERN) === 1) { // the password matches the pattern
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }
}
