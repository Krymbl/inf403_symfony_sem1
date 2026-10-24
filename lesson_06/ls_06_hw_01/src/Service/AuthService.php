<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\UserRegistrationDto;
use App\Entity\User;
use App\Exception\AuthException\EmailAlreadyTakenException;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class AuthService
{

    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function register(UserRegistrationDto $dto): User
    {
        $user = new User(
            email: $dto->email,
            password: $dto->password,
            name: $dto->name,
        );

        $user->setPassword($this->passwordHasher->hashPassword($user, $dto->password));

        try {
            $this->userRepository->save($user);
        } catch (UniqueConstraintViolationException $e) {
            throw new EmailAlreadyTakenException(previous: $e);
        }

        return $user;
    }
}
