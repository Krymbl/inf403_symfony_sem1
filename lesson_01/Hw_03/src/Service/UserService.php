<?php
declare(strict_types=1);

namespace Hw_03\Service;

use Hw_03\DTO\UserDto;
use Hw_03\Exception\UserValidationException;
use Hw_03\Validator\UserRegisterValidator;

final readonly class UserService
{
    /**
     * @throws UserValidationException
     */
    public function register(UserDto $dto): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $validator = new UserRegisterValidator();
        $errors = $validator->validate($dto);

        if ($errors !== []) {
            throw new UserValidationException($errors);
        }


        $_SESSION["user"] = $dto;
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}