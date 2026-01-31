<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\Post;
use App\Processor\UpdatePasswordProcessor;
use App\Validator\Constraint\Password;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\IdenticalTo;
use Symfony\Component\Validator\Constraints\NotBlank;

#[Post(
    uriTemplate: '/profile/change-password',
    processor: UpdatePasswordProcessor::class,
    output: false,
)]
class ChangePasswordRequest
{
    #[UserPassword]
    public string $currentPassword;

    #[Password, NotBlank(message: 'The new password is mandatory.')]
    public string $newPassword;

    #[IdenticalTo(propertyPath: 'newPassword', message: 'Value does not match..'), NotBlank(message: 'Confirmation required.')]
    public string $confirmPassword;
}
