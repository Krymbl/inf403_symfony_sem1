<?php

declare(strict_types=1);

namespace App\Exception\AuthException;

use App\Exception\AbstractBusinessException;
use Symfony\Component\HttpFoundation\Response;

final class EmailAlreadyTakenException extends AbstractBusinessException
{
    protected const int STATUS_CODE = Response::HTTP_CONFLICT;

    public function __construct(
        string $message = 'Пользователь с такой почтой уже существует',
        ?\Throwable $previous = null
    ) {
        parent::__construct(message: $message, previous: $previous);
    }
}
