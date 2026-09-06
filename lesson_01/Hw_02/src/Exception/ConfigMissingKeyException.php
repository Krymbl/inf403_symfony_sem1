<?php

namespace Hw_02\Exception;

final class ConfigMissingKeyException extends ConfigException
{
    public function __construct(
        string $message = "Пропущены обязательные ключи в конфиге:",
        array $keys = [],
    )
    {
        $stringKeys = implode(', ', $keys);
        parent::__construct("$message $stringKeys");
    }
}