<?php

declare(strict_types=1);

namespace Ls_02_Hw_01\Exception;

final class ConfigNotFoundException extends ConfigException
{

    public function __construct(string $message = "Конфиг не найден", $path = "")
    {
        parent::__construct($message.". Путь: $path");
    }
}