<?php
declare(strict_types=1);
namespace Hw_01\Exception;

final class CalculatorValidationException extends \Exception
{
    public function __construct($message = "Ошибка валидации")
    {
        parent::__construct($message);
    }
}