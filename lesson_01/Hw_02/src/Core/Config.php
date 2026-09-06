<?php

namespace Hw_02\Core;

use Dotenv\Dotenv;
use Hw_02\Exception\ConfigMissingKeyException;
use Hw_02\Exception\ConfigNotFoundException;

final class Config
{

    private static array $requiredKeys = [
        'FILE_PATH',
    ];

    /**
     * @throws ConfigNotFoundException
     * @throws ConfigMissingKeyException
     */
    public static function load(string $rootDir): void
    {
        $configDir = $rootDir . "/.env";
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