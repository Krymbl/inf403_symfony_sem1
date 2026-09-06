<?php

declare(strict_types=1);

namespace Hw_01\Exception;

final class InputException extends \Exception
{
    public function __construct($message = "Ошибка ввода")
    {
        parent::__construct($message);
    }
}