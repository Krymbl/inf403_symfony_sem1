<?php

declare(strict_types=1);

namespace Ls_02_Hw_01\Core;

use Dotenv\Dotenv;
use Ls_02_Hw_01\Exception\ConfigMissingKeyException;
use Ls_02_Hw_01\Exception\ConfigNotFoundException;

final class Config
{

    private static array $requiredKeys = [
        "WEATHER_API_KEY",
        "WEATHER_API_URL",
        "JSON_EMULATOR_URL",
    ];

    /**
     * @throws ConfigNotFoundException
     * @throws ConfigMissingKeyException
     */
    public static function load(string $rootDir): void
    {
        $configDir = $rootDir."/.env";
        if (!file_exists($configDir)) {
            throw new ConfigNotFoundException(path: $configDir);
        }

        $dotenv = Dotenv::createImmutable($rootDir);
        $dotenv->load();

        self::validate();
    }

    /**
     * @throws ConfigMissingKeyException
     */
    private static function validate(): void
    {
        $missingKeys = [];
        foreach (self::$requiredKeys as $key) {
            if (empty($_ENV[$key])) {
                $missingKeys[] = $key;
            }
        }

        if (!empty($missingKeys)) {
            throw new ConfigMissingKeyException(keys: $missingKeys);
        }
    }
}