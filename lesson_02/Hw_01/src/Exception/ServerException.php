<?php

declare(strict_types=1);

namespace Ls_02_Hw_01\Exception;

class ServerException extends \Exception
{
    public function __construct(
        string $message = "Ошибка со стороны сервера",
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}