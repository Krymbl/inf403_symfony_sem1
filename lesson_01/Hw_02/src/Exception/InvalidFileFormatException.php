<?php

namespace Hw_02\Exception;

final class InvalidFileFormatException extends FileException
{
    public function __construct(string $message = "Неправильный формат файла: ", string $filePath = "")
    {
        parent::__construct($message.$filePath);
    }
}