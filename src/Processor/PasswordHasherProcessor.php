<?php

namespace App\Processor;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordHasherProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private UserPasswordHasherInterface $passwordHasher
    ){
    }  

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if($data instanceof User){
            $encodedPassword = $this->passwordHasher->hashPassword($data, $data->getPassword());
            $data->setPassword($encodedPassword);
        } 
        //dd($data, $context);
        $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        // call your persistence layer to save $data
        return $data;
    }

    
}
