<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\MailRecipientDto;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

final readonly class MailGenerationService
{
    public function __construct(
        private PersonalizedGreetingService $greetingService,
        private Filesystem $filesystem,
        #[Autowire(param: 'app.mail_generation.reply_to')]
        private string $replyTo,
        #[Autowire(param: 'app.mail_generation.directory')]
        private string $directory,
    ) {
    }

    /**
     * @param MailRecipientDto[] $recipients
     * @return list<string>
     */
    public function generate(array $recipients): array
    {
        $files = [];
        $paths = [];

        try {
            foreach ($this->greetingService->generate($recipients) as $recipient) {
                $file = 'message_' . bin2hex(random_bytes(8)) . '.txt';
                $path = $this->directory . '/' . $file;
                $message = "To: {$recipient['email']}\n"
                    . "Reply-To: {$this->replyTo}\n"
                    . "Subject: Приветствие\n\n"
                    . "{$recipient['greeting']}\n";

                $this->filesystem->dumpFile($path, $message);
                $files[] = $file;
                $paths[] = $path;
            }
        } catch (IOExceptionInterface $e) {
            $this->filesystem->remove($paths);

            throw new \RuntimeException('Не удалось сохранить письма', previous: $e);
        }

        return $files;
    }
}
