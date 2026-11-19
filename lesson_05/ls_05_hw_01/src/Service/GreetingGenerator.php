<?php

declare(strict_types=1);

namespace App\Service;

final class GreetingGenerator
{
    public function getGreeting(string $name): string
    {
        $messages = [
            'Здравствуйте, %s!',
            'Привет, %s!',
            'Добрый день, %s!',
        ];

        return sprintf($messages[array_rand($messages)], $name);
    }
}
