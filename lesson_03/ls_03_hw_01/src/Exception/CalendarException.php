<?php

namespace App\Exception;


class CalendarException extends \Exception
{
    public function __construct(
        string $message = 'Ошибка валидации Календаря',
        int $code = 0,
        ?\Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
