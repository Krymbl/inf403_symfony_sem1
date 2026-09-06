<?php

declare(strict_types=1);

namespace Hw_03\Core;

use Hw_03\DTO\UserDto;
use Hw_03\Exception\SecurityException;
use Hw_03\Exception\ServerException;

abstract readonly class AbstractController
{
    /**
     * @throws ServerException
     */
    protected function render(string $view, array $data = []): string
    {
        $templatePath = ROOT_DIR . "/templates/" . $view . ".php";
        $realPath = realpath($templatePath);
        $templatesDir = realpath(ROOT_DIR . '/templates');

        if ($realPath === false || !is_file($realPath)) {
            throw new ServerException("Шаблон не найден: $view");
        }

        if (!str_starts_with($realPath, $templatesDir . DIRECTORY_SEPARATOR)) {
            throw new ServerException("Недопустимый путь к шаблону: $view");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $realPath;

        return ob_get_clean();
    }

    protected function redirect(string $url, int $status = 303): never
    {
        header("Location: $url", true, $status);
        exit;
    }

    protected function getUser(): ?UserDto
    {
        $user = $_SESSION["user"] ?? null;

        return $user instanceof UserDto ? $user : null;
    }

    protected function setFlash(string $key, string $message): void
    {
        $_SESSION["flash"][$key] = $message;
    }

    protected function getFlash(string $key): ?string
    {
        $flash = $_SESSION["flash"][$key] ?? null;
        unset($_SESSION["flash"][$key]);

        return $flash;
    }

    protected function getCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    /**
     * @throws SecurityException
     */
    protected function validateCsrfToken(): void
    {
        $token = (string) ($_POST["csrf_token"] ?? '');

        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            throw new SecurityException("Неверный CSRF токен");
        }
    }

    protected function e(?string $string): string
    {
        return htmlspecialchars($string ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}