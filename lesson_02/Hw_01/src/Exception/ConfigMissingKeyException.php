<?php

declare(strict_types=1);

namespace Ls_02_Hw_01\Exception;

final class ConfigMissingKeyException extends ConfigException
{
    public function __construct(
        string $message = "Пропущены обязательные ключи в конфиге:",
        array $keys = [],
    ) {
        $stringKeys = implode(', ', $keys);
        parent::__construct("$message $stringKeys");
    }
}