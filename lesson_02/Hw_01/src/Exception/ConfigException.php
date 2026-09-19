<?php

declare(strict_types=1);

namespace Ls_02_Hw_01\Exception;

class ConfigException extends ServerException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}