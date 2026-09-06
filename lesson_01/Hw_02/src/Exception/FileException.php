<?php

namespace Hw_02\Exception;

class FileException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}