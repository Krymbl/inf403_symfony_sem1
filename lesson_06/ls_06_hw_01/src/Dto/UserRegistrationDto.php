<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\User;
use App\Validator\StrongPassword;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(
    fields: ['email'],
    message: 'Пользователь с такой почтой уже существует',
    entityClass: User::class,
    errorPath: 'email',
    identifierFieldNames: ['id'],
)]
#[StrongPassword]
class UserRegistrationDto
{

    public ?int $id = null;

    #[Assert\NotBlank(message: 'Почта обязательна')]
    #[Assert\Email(message: 'Введите почту в правильном формате: example@gmail.com')]
    #[Assert\Length(max: 150, maxMessage: 'Почта максимум {{ limit }} символов')]
    public ?string $email = null;

    #[Assert\NotBlank(message: 'Пароль обязателен')]
    #[Assert\Length(
        min: 8,
        max: 100,
        minMessage: 'Пароль минимум {{ limit }} символов',
        maxMessage: 'Пароль максимум {{ limit }} символов',
    )]
    public ?string $password = null;

    #[Assert\NotBlank(message: 'Имя обязательно')]
    #[Assert\Length(
        min: 2,
        max: 30,
        minMessage: 'Имя минимум {{ limit }} символов',
        maxMessage: 'Имя максимум {{ limit }} символов',
    )]
    #[Assert\Regex(
        pattern: '/^\p{L}+(-\p{L}+)*$/u',
        message: 'Имя может содержать только буквы и дефис',
    )]
    public ?string $name = null;

}
