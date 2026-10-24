<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class AbstractBusinessException extends HttpException
{
    protected const int STATUS_CODE = Response::HTTP_INTERNAL_SERVER_ERROR;

    public function __construct(
        string $message = '',
        ?\Throwable $previous = null,
        int $code = 0,
        array $headers = [],
    ) {
        parent::__construct(
            statusCode: static::STATUS_CODE,
            message: $message,
            previous: $previous,
            headers: $headers,
            code: $code,
        );
    }
}
