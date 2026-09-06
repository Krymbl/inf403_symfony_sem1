<?php

declare(strict_types=1);

namespace Hw_03\Exception;

final class SecurityException extends \Exception
{
    public function __construct(
        string $message = "Ошибка безопасности",
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, 0, $previous);
    }
}
