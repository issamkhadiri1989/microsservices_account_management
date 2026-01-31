<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class PasswordEncoder
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {
    }

    public function hashAccountPassword(User $account, #[\SensitiveParameter] string $plainPassword): User
    {
        $hashedPassword = $this->passwordEncoder->hashPassword(plainPassword: $plainPassword, user: $account);
        $account->setPassword($hashedPassword);

        return $account;
    }
}
