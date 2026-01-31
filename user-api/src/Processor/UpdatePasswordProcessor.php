<?php

declare(strict_types=1);

namespace App\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\ChangePasswordRequest;
use App\Processor\Trait\UserAwareTrait;
use App\Security\PasswordEncoder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class UpdatePasswordProcessor implements ProcessorInterface
{
    use UserAwareTrait;

    public function __construct(
        private Security $security,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')] private ProcessorInterface $persistProcessor,
        private EntityManagerInterface $entityManager,
        private PasswordEncoder $passwordEncoder,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $user = $this->getUser();

        if ($data instanceof ChangePasswordRequest && $operation instanceof Post) {
            $this->passwordEncoder->hashAccountPassword(account: $user, plainPassword: $data->newPassword);

            $this->entityManager->flush();
        }

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
