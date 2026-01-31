<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\Patch;
use App\Processor\PatchUserProfileProcessor;
use Symfony\Component\Validator\Constraints\NotBlank;

#[Patch(
    uriTemplate: '/profile',
    processor: PatchUserProfileProcessor::class,
)]
class UpdateProfileRequest
{
    #[NotBlank]
    public string $firstName;

    #[NotBlank]
    public string $lastName;
}
