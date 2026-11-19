<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class MailGenerationDto
{
    /** @var MailRecipientDto[] */
    #[Assert\Count(min: 1, minMessage: 'Добавьте хотя бы одного получателя')]
    #[Assert\Valid]
    public array $recipients = [];
}
