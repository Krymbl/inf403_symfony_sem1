<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\MailRecipientDto;

final readonly class PersonalizedGreetingService
{
    public function __construct(
        private GreetingGenerator $greetingGenerator,
    ) {
    }

    /**
     * @param MailRecipientDto[] $recipients
     * @return list<array{email: string, greeting: string}>
     */
    public function generate(array $recipients): array
    {
        $greetings = [];

        foreach ($recipients as $recipient) {
            $greetings[] = [
                'email' => $recipient->email,
                'greeting' => $this->greetingGenerator->getGreeting($recipient->name),
            ];
        }

        return $greetings;
    }
}
