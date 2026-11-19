<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class MailRecipientDto
{
    #[Assert\NotBlank(message: 'Введите имя')]
    #[Assert\Length(max: 100)]
    public string $name = '';

    #[Assert\NotBlank(message: 'Введите почту')]
    #[Assert\Email(message: 'Введите корректный адрес почты')]
    #[Assert\Length(max: 254)]
    public string $email = '';
}
