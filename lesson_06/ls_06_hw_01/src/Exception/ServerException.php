<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

final class ServerException extends AbstractBusinessException
{
    protected const int STATUS_CODE = Response::HTTP_INTERNAL_SERVER_ERROR;

    public function __construct(
        string $message = 'Ошибка со стороны сервера, попробуйте ещё раз',
        ?\Throwable $previous = null,
    ) {
        parent::__construct(message: $message, previous: $previous);
    }
}
