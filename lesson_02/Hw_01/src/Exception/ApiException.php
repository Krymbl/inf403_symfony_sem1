<?php

namespace Ls_02_Hw_01\Exception;

use Throwable;

final class ApiException extends \Exception
{
    public function __construct(
        $message = "Проблема подключения к стороннему сервису",
        $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}