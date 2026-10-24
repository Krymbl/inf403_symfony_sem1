<?php

declare(strict_types=1);

namespace App\Exception\Grade;

use App\Exception\AbstractBusinessException;
use Symfony\Component\HttpFoundation\Response;

final class GradeNotFoundException extends AbstractBusinessException
{
    protected const int STATUS_CODE = Response::HTTP_NOT_FOUND;

    public function __construct(
        string $message = 'Оценка не найдена',
        ?\Throwable $previous = null
    ) {
        parent::__construct(message: $message, previous: $previous);
    }
}
