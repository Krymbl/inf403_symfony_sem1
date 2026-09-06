<?php

namespace Hw_02\Exception;

final class InvalidFileException extends FileException
{
    public function __construct(string $message = "Проблема при работе с файлом")
    {
        parent::__construct($message);
    }
}