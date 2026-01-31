<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Password extends Constraint
{
    public string $message = 'The password you provided does not meet the requirements.';

    public const string ERROR_PASSWORD_NOT_COMPLIANT = 'b7f3c2a4-8d9e-4f2a-9c1d-6a2f4e7d9b21';
}
