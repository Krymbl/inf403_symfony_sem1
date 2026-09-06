<?php

namespace Hw_02\Exception;

class ConfigException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}