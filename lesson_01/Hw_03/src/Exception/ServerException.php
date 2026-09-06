<?php

declare(strict_types=1);

namespace Hw_03\Exception;

final class ServerException extends \Exception
{
    public function __construct(
        string $message = "Ошибка со стороны сервера",
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}