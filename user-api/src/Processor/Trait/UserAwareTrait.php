<?php

declare(strict_types=1);

namespace App\Processor\Trait;

use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

trait UserAwareTrait
{
    public function getUser(): User
    {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            throw new AccessDeniedHttpException('You need to authenticate before continue.');
        }

        return $user;
    }
}
