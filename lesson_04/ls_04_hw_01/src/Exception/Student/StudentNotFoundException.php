<?php

declare(strict_types=1);

namespace App\Exception\Student;

use App\Exception\AbstractBusinessException;
use Symfony\Component\HttpFoundation\Response;

final class StudentNotFoundException extends AbstractBusinessException
{
    protected const int STATUS_CODE = Response::HTTP_NOT_FOUND;

    public function __construct(
        string $message = 'Студент не найден',
        ?\Throwable $previous = null,
    ) {
        parent::__construct(message: $message, previous: $previous);
    }
}
