<?php

declare(strict_types=1);

namespace App\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\UpdateProfileRequest;
use App\Processor\Trait\UserAwareTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;


final readonly class PatchUserProfileProcessor implements ProcessorInterface
{
    use UserAwareTrait;

    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')] private ProcessorInterface $persistProcessor,
        private Security $security,
        private  EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $user = $this->getUser();

        if ($data instanceof UpdatePRofileRequest) {
            $user->setFirstName($data->firstName)
                ->setLastName($data->lastName);

            $this->entityManager->flush();
        }

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
