<?php

namespace Hw_02\Exception;

final class InvalidStudentsDataException extends \Exception
{
    public function __construct(string $message = "Неправильный формат данных студентов")
    {
        parent::__construct($message);
    }
}