<?php

declare(strict_types=1);

namespace Hw_03\Exception;

final class UserValidationException extends \Exception
{
    private array $errors;

    public function __construct(
        array $errors,
        string $message = "",
        int $code = 0,
        ?\Throwable $previous = null,
    ) {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}