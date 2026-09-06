<?php

namespace Hw_02\Exception;

final class ConfigNotFoundException extends ConfigException
{

    public function __construct(string $message = "Конфиг не найден", $path = "")
    {
        parent::__construct($message . ". Путь: $path");
    }
}