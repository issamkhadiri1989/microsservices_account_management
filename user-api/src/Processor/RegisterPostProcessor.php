<?php

declare(strict_types=1);

namespace App\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use App\Security\PasswordEncoder;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class RegisterPostProcessor implements ProcessorInterface
{
    public function __construct(
        private PasswordEncoder $passwordEncoder,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')] private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if ($data instanceof User && $operation instanceof Post) {
            $this->passwordEncoder->hashAccountPassword(account: $data, plainPassword: $data->getPassword());
        }

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
